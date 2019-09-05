<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        //链接redis
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        //if($redis->exists('ticket_info')){}
        //判断redis里面有没有ticket_key
        if(!$redis->get('ticket_info')){
            //判断搜索条件是否存在
            if(!empty($req['start_place']) ||  !empty($req['end_place'])){
                //记录搜索次数
                $redis->incr('ticket_num');
                $list = \DB::connection('mysql_cart')->table('plan')
                    ->where('place','like',"%{$req['start_place']}%")
                    ->where('ofplace','like',"%{$req['end_place']}%")
                    ->get();

            }else{
                //没有搜索条件返回全部数据
                $list = \DB::connection('mysql_cart')->table('plan')->get();
            }
            //redis获取访问次数
            $ticket_num = $redis->get('ticket_num');
            //判断访问次数
            if($ticket_num > 5){
                $redis_info = json_encode($list);
                $redis->set('ticket_info',$redis_info,3 * 60);
            }
        }else{
            $list = json_decode($redis->get('ticket_info'),true);
            var_dump($list);
        }

        echo "访问次数:".$redis->get('ticket_num');

        //$redis->set('key','');
        return view('Ticket.index',['start_place'=>$req['start_place'],'end_place'=>$req['end_place']]);
=======
use DB;

class TicketController extends Controller
{
    public function add(){

       return view('/ticketCOntroller/add');
    }
    public function do_add(){
        $data = request()->all();
//         dump($data);die;
        unset($data['_token']);
        $post=DB::table('ticket')->insert($data);
        // dump($post);
        if($post){
            return redirect('ticket/index');
        }else{
            return redirect()->back();
        }
    }
    public function index(){
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');

        //搜索
        $keywords=request()->all();
        if(!empty($keywords['chufadi']) || !empty($keywords['daodadi'])){
            $redis->incr('num');
            $num = $redis->get('num');
            echo"以搜索：".$num."次";
        }
        $where = [];
        if ($keywords['chufadi']??'') {
            $where[]=['chufadi','like',"%$keywords[chufadi]%"];
        }
        if ($keywords['daodadi']??'') {
            $where[]=['daodadi','like',"%$keywords[daodadi]%"];
        }
          $pagesize=config('app.pageSize');
        $data = DB::table('ticket')->where($where)->paginate($pagesize);
        return view('/ticketController/index',['data'=>$data,'keywords'=>$keywords]);
>>>>>>> 9ec5512c86dc07bda9e6776e273334fd4b37d61b
    }
}
