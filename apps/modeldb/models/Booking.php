<?php
namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;
use Phalcon\Di;

class Booking extends Model
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
    public $is_sex;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $dateto;

    /**
     *
     * @var string
     */
    public $datefrom;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $is_status;

    /**
     *
     * @var string
     */
    public $datecreate;

    /**
     * Validations and business logic
     *
     * @return boolean
     */

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'booking';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Booking[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Booking
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findBookPaging($page, $limit, $name, $phone)
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($page, $limit, $name, $phone));

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $queryBuilder,
            "limit" => (int)$limit,
            "page" => (int)$page
        ));
        return $paginator->getPaginate();
    }

    private static function buildparams($page, $limit, $name, $phone)
    {
        $conditions = "1=1 ";
        if ($name != '')
            $conditions = $conditions . "and name like '%$name%' ";
        if ($phone != '')
            $conditions = $conditions . "and phone like '%$phone%' ";
        return $params = array(
            'models' => array('Webdinhdalat\Modeldb\Models\Booking'),
            'conditions' => $conditions,
            'order' => 'datecreate desc, name'
        );
    }

}
