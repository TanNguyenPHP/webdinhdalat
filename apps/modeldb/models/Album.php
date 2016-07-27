<?php
namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;

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

    public static function findAlbumOfPicPagingShowWeb($page = "", $limit = "")
    {
        $query = new \Phalcon\Mvc\Model\Query\Builder();// lay nhung album co anh kem theo
        $query->addFrom('Webdinhdalat\Modeldb\Models\Album', 'a')
            ->columns('a.id,a.name,p.dir')
            ->innerJoin('Webdinhdalat\Modeldb\Models\Picture', 'p.id_album = a.id', 'p')
            ->where("p.is_del = '0' and a.is_del = '0' and a.is_website='1'")
            ->groupBy(array('a.id'))
            ->orderBy('a.datecreate desc');
        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $query,
            "limit" => (int)$limit,
            "page" => (int)$page
        ));
        return $paginator->getPaginate();
    }

    public static function findAllAlbum($id = "", $name = "", $is_website = "")
    {
        $query = new \Phalcon\Mvc\Model\Query\Builder();
        $query->addFrom('Webdinhdalat\Modeldb\Models\Album', 'a')
            ->columns('a.name,a.id')
            ->innerJoin('Webdinhdalat\Modeldb\Models\Picture', 'p.id_album = a.id', 'p')
            ->where("p.is_del = '0' and a.is_del = '0'")
            ->groupBy(array('a.name,a.id'))
            ->orderBy('a.datecreate desc');
        return $query->getQuery()->execute();
    }

    public static function findPicOfAlbum($id_album = "", $name = "", $is_website = "")
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($id_album, $name, $is_website));

        //$PicOfAlbums = $queryBuilder->getQuery()->execute();
        $albums = self::findAllAlbum();

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $queryBuilder,
            "limit" => '100',
            "page" => '1'
        ));
        //return $queryBuilder->getQuery()->execute();
        $tets = $paginator->getPaginate();

        return array('albums' => $albums, 'pic' => $tets);
    }



}
