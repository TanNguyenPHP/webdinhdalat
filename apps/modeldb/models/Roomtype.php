<?php

namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;

class Roomtype extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     *
     * @var string
     */
    public $avatar_image;

    /**
     *
     * @var string
     */
    public $is_show;

    /**
     *
     * @var string
     */
    public $persons;

    /**
     *
     * @var string
     */
    public $id_album;

    /**
     *
     * @var string
     */
    public $seo_title;

    /**
     *
     * @var string
     */
    public $seo_desc;

    /**
     *
     * @var string
     */
    public $slug;

    /**
     *
     * @var string
     */
    public $id_lang;
    public $position;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'roomtype';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Roomtype[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Roomtype
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findAll($name = '', $id_lang = '')
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($name = '', $id_lang = ''));

        return $queryBuilder->getQuery()->execute();
    }
    private static function buildparams($name = '', $id_lang = '')
    {
        $conditions = "1=1 ";
        if ($id_lang != '')
            $conditions = $conditions . " and id_lang = '$id_lang' ";
        if ($name != '')
            $conditions = $conditions . " and name = '$name' ";
        return $params = array(
            'models' => array('Webdinhdalat\Modeldb\Models\Roomtype'),
            'columns' => array('id', 'name', 'id_lang', 'position', 'is_show'),
            'conditions' => $conditions,
            'order' => 'position'
        );
    }
}
