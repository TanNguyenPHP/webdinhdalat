<?php
namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;

class Roombook extends Model
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
    public $checkin;

    /**
     *
     * @var string
     */
    public $checkout;

    /**
     *
     * @var string
     */
    public $datecreate;

    /**
     *
     * @var string
     */
    public $persons;

    /**
     *
     * @var string
     */
    public $is_status;

    /**
     *
     * @var string
     */
    public $cellphone;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $id_roomtype;
    public $children;
    public $roomnumber;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'roombook';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Roombook[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Roombook
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findRoomBookPaging($page,$limit,$filter='')
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($filter));

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $queryBuilder,
            "limit" => (int)$limit,
            "page" => (int)$page
        ));
        return $paginator->getPaginate();
    }
    private static function buildparams($filter='')
    {
        $conditions = "1=1 ";
        if ($filter != '')
            $conditions = $conditions . " and ( name like '%$filter%' or cellphone like '%$filter%' )";
        return $params = array(
            'models' => array('Webdinhdalat\Modeldb\Models\Roombook'),
            'conditions' => $conditions
        );
    }
}
