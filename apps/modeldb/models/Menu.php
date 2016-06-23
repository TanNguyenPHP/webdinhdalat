<?php
namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;
class Menu extends Model
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
     * @var integer
     */
    public $id_lang;

    /**
     *
     * @var string
     */
    public $url;

    /**
     *
     * @var string
     */
    public $position;
    public $is_active;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'menu';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Menu[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    public static function findall($id_lang ='')
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($id_lang));

        return $queryBuilder->getQuery()->execute();
    }
    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Menu
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    private static function buildparams($id_lang ='')
    {
        $conditions = '1=1';
        if ($id_lang != '')
            $conditions = $conditions . " and id_lang = '$id_lang' ";
        return $params = array(
            'models' => array('Webdinhdalat\Modeldb\Models\Menu'),
            'columns' => array('id', 'name','id_lang','url','position','is_active'),
            'conditions' => $conditions,
            // or 'conditions' => "created > '2013-01-01' AND created < '2014-01-01'",
            'order' => array('name')
            // or 'limit' => array(20, 20),
        );
    }
}