<?php
namespace App\Http\Requests\Admin;

class ActiviableRequest {

    public static function validation_rules($lang_prefix = null, $activiable_bag = false) {
        $translations = trans('admin/activiable/validation');
        $langs = isset($lang_prefix)?
            transOrOther($lang_prefix, 'admin/activiable/validation', array_keys($translations)) : $translations;
        $activiable_bag = $activiable_bag? $activiable_bag : 'active';
        return [
            $activiable_bag.'.period_type' => 'boolean',
            $activiable_bag.'.period_from.date' => ['nullable',  function($attribute, $value, $fail) use ($langs) {
                if(!($dt = \DateTime::createFromFormat('d.m.Y', $value))) {
                    return $fail( $langs['period_from_not_correct'] );
                }
            }],
            $activiable_bag.'.period_from.hour' => [ function($attribute, $value, $fail) use ($langs) {
                $value = (int)$value;
                if($value < 0 || $value > 23) {
                    return $fail( $langs['period_from_hour_not_correct'] );
                }
            }],
            $activiable_bag.'.period_from.minutes' => [ function($attribute, $value, $fail) use ($langs) {
                $value = (int)$value;
                if($value < 0 || $value > 59) {
                    return $fail( $langs['period_from_minutes_not_correct'] );
                }
            }],
            $activiable_bag.'.period_to.date' => ['nullable', function($attribute, $value, $fail) use ($langs) {
                if(!($dt = \DateTime::createFromFormat('d.m.Y', $value))) {
                    return $fail( $langs['period_to_not_correct'] );
                }
            }],
            $activiable_bag.'.period_to.hour' => [ function($attribute, $value, $fail) use ($langs) {
                $value = (int)$value;
                if($value < 0 || $value > 23) {
                    return $fail( $langs['period_to_hour_not_correct'] );
                }
            }],
            $activiable_bag.'.period_to.minutes' => [ function($attribute, $value, $fail) use ($langs) {
                $value = (int)$value;
                if($value < 0 || $value > 59) {
                    return $fail( $langs['period_to_minutes_not_correct'] );
                }
            }],
        ];
    }

    public static function validation_prework(&$inputs, $activiable_bag = false) {
        $activiable_bag = $activiable_bag? $activiable_bag : 'active';
        $inputs[$activiable_bag]['period_type'] = isset($inputs[$activiable_bag])? (boolean)((int)$inputs[$activiable_bag]['period_type']) : false;
        return $inputs;
    }

    public static function validateData(&$validatedData, $activiable_bag = false) {
        $activiable_bag = $activiable_bag? $activiable_bag : 'active';
        $validatedData['period_type'] = $validatedData[$activiable_bag]['period_type'];
        $validatePeriodArr = $validatedData[$activiable_bag]['period_from'];
        $periodFrom = "{$validatePeriodArr['date']} {$validatePeriodArr['hour']}:{$validatePeriodArr['minutes']}";
        $validatePeriodArr = $validatedData[$activiable_bag]['period_to'];
        $periodTo = "{$validatePeriodArr['date']} {$validatePeriodArr['hour']}:{$validatePeriodArr['minutes']}";
//            dump($periodFrom);
//            dd($periodTo);
        if(!($validatedData['period_from'] = \DateTime::createFromFormat('d.m.Y H:i', $periodFrom))) {
            $validatedData['period_from'] = null;
        }
        if(!($validatedData['period_to'] = \DateTime::createFromFormat('d.m.Y H:i', $periodTo))) {
            $validatedData['period_to'] = null;
        }
        if($validatedData['period_from'] && $validatedData['period_to'] && $validatedData['period_from'] > $validatedData['period_to']) {
            $buf = clone $validatedData['period_from'];
            $validatedData['period_from'] = clone $validatedData['period_to'];
            $validatedData['period_to'] = clone $buf;
        }
        unset($validatedData[$activiable_bag]);
    }
}
