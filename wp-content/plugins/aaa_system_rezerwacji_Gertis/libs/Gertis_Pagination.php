<?php

/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 12.03.2017
 * Time: 11:22
 */
class Gertis_Pagination{

    private $items;

    private $order_by;
    private $order_dir;

//    private $filter;

    private $limit;
    private $total_count;

    private $curr_page;
    private $last_page;


    function __construct($items, $order_by, $order_dir, $limit, $total_count, $curr_page, $last_page) {
        $this->items = $items;
        $this->order_by = $order_by;
        $this->order_dir = $order_dir;
        $this->limit = $limit;
        $this->total_count = $total_count;
        $this->curr_page = $curr_page;
        $this->last_page = $last_page;
        //$this->filter = $filter;
    }

    public function hasItems(){
        return (!empty($this->items));
    }


    public function getItems() {
        return $this->items;
    }

    public function getOrderBy() {
        return $this->order_by;
    }

    public function getOrderDir() {
        return $this->order_dir;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getTotalCount() {
        return $this->total_count;
    }

    public function getCurrPage() {
        return $this->curr_page;
    }

    public function getLastPage() {
        return $this->last_page;
    }

//    public function getFilter() {
//        return $this->filter;
//    }

}