<?php
namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;
use Webdinhdalat\Modeldb\Models\Picture;

class Album extends Model
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
    public $dir;

    /**
     *
     * @var string
     */
    public $folder;

    /**
     *
     * @var string
     */
    public $is_del;

    /**
     *
     * @var string
     */
    public $datecreate;
    public $desc;
    public $is_website;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'album';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Album[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function findAll($name = "")
    {
        return parent::find(array("name like '%$name%' and is_del = '0'", 'order' => 'datecreate desc'));
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Album
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findPicOfAlbum($name = "")
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($name));
        //$query = $queryBuilder->getPhql();
        $queryBuilder->getQuery()->execute();

        $query = new \Phalcon\Mvc\Model\Query\Builder();
        $query->addFrom('Webdinhdalat\Modeldb\Models\Album', 'a')
            ->columns('a.name')
            ->join('Webdinhdalat\Modeldb\Models\Picture', 'p.id_album = a.id', 'p');
        $data = $query->getQuery()->execute();
        return $data;
    }

    private static function buildparams($name = '')
    {
        //$query = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($id_lang));

        $conditions = '1=1';
        if ($name != '')
            $conditions = $conditions . " and a.name = '$name' ";
        return $params = array(
            'models' => array('a'=>'Webdinhdalat\Modeldb\Models\Album'),
            'columns' => ('a.name'),
            'innerJoin' => array('0' => array('Webdinhdalat\Modeldb\Models\Picture', 'p.id_album = a.id', 'p'))
            //'conditions' => $conditions
            // or 'conditions' => "created > '2013-01-01' AND created < '2014-01-01'",
            //'order' => array('a.id')
            // or 'limit' => array(20, 20),
        );
    }

}
