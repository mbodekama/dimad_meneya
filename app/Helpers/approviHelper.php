<?php
  use App\Model\succursale;
  // use DB;

if(!function_exists('getSuccInfo'))
{
	function getSuccInfo($id_succ)
	{
         $sucInfo = DB::table('succursales')
            ->join('users','users.id','=','succursales.user_id')
            ->select('users.*', 'succursales.*')
            ->where('succursales.id','=',$id_succ)
            ->get()
            ->first();
// dd($sucInfo);
            return $sucInfo;
	}
}
