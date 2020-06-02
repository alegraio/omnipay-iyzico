<?php


namespace Omnipay\Iyzico;


interface IyzicoItemInterface
{
    public function setId($id);
    public function getId();
    public function setName($name);
    public function getName();
    public function setCategory1($category1);
    public function getCategory1();
    public function setCategory2($category2);
    public function getCategory2();
    public function setItemType($itemType);
    public function getItemType();
}