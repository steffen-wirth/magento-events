<?php
/**
 * Event Collection resource
 */
class DG_Events_Model_Resource_Event_Collection extends
        Mage_Core_Model_Resource_Db_Collection_Abstract {
    
    protected function _construct() {
        parent::_construct();
        $this->_init('events/event');
    }
    
    /**
     * Filters the Events collection to just get the month we are looking at
     *
     * @param string $month the month number as a string ie for april $month='04'
     * @param $year year as 4-digits e.g. 2013
     * @return DG_Events_Model_Resource_Event_Collection
     */
    public function addMonthFilter($month, $year) {

        $nextmonth = $month + 1;
        $firstdayofmonth = $year.'-'.$month.'-01' ;
        $firstdayofnextmonth = $year.'-'.$nextmonth.'-01';
        
        $this->getSelect()
            ->where('date >= ?', $firstdayofmonth)
            ->where('date < ?', $firstdayofnextmonth);
        
        return $this;
    }
    
    /**
     * Filters the event by the store number defined in the helper module
     * 
     * @param integer $storeid
     * @return DG_Events_Model_Resource_Event_Collection
     */
    public function addStoreFilter($storeid) {
        $storeid = intval($storeid);
        if ($storeid >= 0 && $storeid < count(Mage::helper('events')->getStores())) {
            $wherestring = sprintf('main_table.store LIKE %s',
                    $this->getConnection()->quote('%"'.$storeid.'"%'));
            $this->getSelect()->where($wherestring);
        }
        
        return $this;
    }
}
