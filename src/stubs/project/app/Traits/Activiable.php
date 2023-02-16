<?php
    namespace App\Traits;


    trait Activiable {
        public function scopeActive($query, $now = false, $unActive = false) {
            $qry1 = "period_from AND period_to AND ((!period_type AND period_from <= ? AND period_to >= ?) OR (period_type AND (period_from > ? OR period_to < ?) ))";
            $qry2 = "period_from AND period_to IS NULL AND ((!period_type AND period_from <= ?) OR (period_type AND period_from > ?))";
            $qry3 = "period_to AND period_from IS NULL AND ((!period_type AND period_to >= ?) OR (period_type AND period_to < ?))";
            $qry4 = "period_from IS NULL AND period_to IS NULL AND !period_type";
            $now = $now? $now : new \Datetime();
            $unActiveFlag = $unActive? '!' : '';
            return $query->whereRaw("{$unActiveFlag}( ({$qry1}) OR ({$qry2}) OR ({$qry3}) OR ({$qry4})  )", [$now, $now, $now, $now, $now, $now, $now, $now]);
        }

        public function getActiveAttribute() {
            $now = new \DateTime();
            if($period_fromDT = $this->period_from) {
                if($now < $period_fromDT) {
                    return (boolean)$this->period_type;
                }
            }
            if($period_toDT = $this->period_to) {
                if($now > $period_toDT) {
                    return (boolean)$this->period_type;
                }
            }
            return !(boolean)$this->period_type;
        }

    }
