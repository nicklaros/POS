<?php

use ORM\MenuQuery;
use ORM\OptionQuery;
use ORM\UserQuery;
use Propel\Runtime\Propel;

class Mains {

    function login(stdClass $params) {
        require 'session.php';

        $con = Propel::getConnection('pos');
        $con->beginTransaction();

        try{
            $user = UserQuery::create()
                ->filterByUser($params->user)
                ->count($con);

            if($user == 0) throw new Exception('User ID yang Anda masukkan salah');

            $user = UserQuery::create()
                ->filterByUser($params->user)
                ->filterByPassword($params->pass)
                ->select(array(
                    'id',
                    'user',
                    'role_id'
                ))
                ->leftJoin('Detail')
                ->withColumn('Detail.Name', 'name')
                ->withColumn('Detail.Address', 'address')
                ->withColumn('Detail.Phone', 'phone')
                ->findOne($con);

            if(!$user) throw new Exception('Password tidak sesuai dengan User ID yang Anda masukkan');

            if(!$user['role_id']) throw new Exception('Anda belum mempunyai Jabatan. Mohon hubungi petugas berwenang dan mintalah Jabatan terlebih dahulu.');

            $menu = $this->getMenu(1, $con);

            $results['success'] = true;
            $results['state'] = 1;
            $results['current_user'] = (object) $user;
            $results['menu'] = $menu;

            $session->set('pos/state', 1);
            $session->set('pos/current_user', (object) $user);

            $con->commit();
        }catch(Exception $e){
            $con->rollBack();

            $results['success'] = false;
            $results['errmsg'] = $e->getMessage();
        }

        return $results;
    }

    function logout(){
        require 'session.php';

        $con = Propel::getConnection('pos');
        $con->beginTransaction();

        try{
            $menu = $this->getMenu(0, $con);

            $results['state'] = 0;
            $results['current_user']['name'] = 'Silahkan Masuk';
            $results['menu'] = $menu;

            $session->set('pos/state', 0);
            $session->set('pos/current_user', $results['current_user']);

            $results['success'] = true;

            $con->commit();
        }catch(Exception $e){
            $con->rollBack();

            $results['success'] = false;
            $results['errmsg'] = $e->getMessage();
        }

        return $results;
    }
    
    function changeAppPhoto($params){
        require 'session.php';

        $con = Propel::getConnection('pos');
        $con->beginTransaction();

        $operationTime = time();
        $unique = session_id().time();

        $file = $_FILES['photo'];
        
        
        $folder = $session->get('pos/folder') . '/resources/images/';

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newfile = $unique . '.' . $ext;
        $newfile_full_path = $folder . $newfile;

        try{
            if ($file['name'] == '') throw new Exception('Missing file');
            if ($file['error'] > 0) throw new Exception($file['error']);

            move_uploaded_file($file['tmp_name'], $newfile_full_path);

            $appPhoto = OptionQuery::create()
                ->filterByName([
                    'app_photo'
                ])
                ->findOne($con);
            
            $appPhoto
                ->setValue($newfile)
                ->save($con);

            $results['success'] = true;
            $results['photo'] = $newfile;

            $con->commit();
        }catch(Exception $e){
            $con->rollBack();

            $results['success'] = false;
            $results['errmsg'] = $e->getMessage();
        }

        return $results;
    }

    private function getMenu($state, $con){
        $result = [];

        $menus = MenuQuery::create()
            ->filterByStatus('Active');

        ($state == 1 || $menus->filterByState($state));

        $menus
            ->select(array(
                'sub',
                'icon',
                'text',
                'action'
            ))
            ->orderBy('sub', 'ASC')
            ->orderBy('order', 'ASC')
            ->find($con);

        foreach($menus as $row){
            $result[$row['sub']][] = $row;
        }

        return $result;
    }

}