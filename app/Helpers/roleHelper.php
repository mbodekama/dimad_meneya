<?php
use App\Model\user_has_acces;
use App\Model\succursale;
use App\Model\abonnement;
use App\Model\offres;


if(!function_exists('getRole'))
{
	function getRole()
	{
		$role = DB::table('role_has_users')
            ->join('roles', 'roles.id', '=', 'role_has_users.roles_id')
            ->select('roles.*')
            ->where('role_has_users.user_id','=', Auth::id())
            ->first();

           return $role->libelle;

	}
}


if(!function_exists('isSuperAdmin'))
{
	function isSuperAdmin()
	{
		$role = DB::table('role_has_users')
            ->join('roles', 'roles.id', '=', 'role_has_users.roles_id')
            ->select('roles.*')
            ->where('role_has_users.user_id','=', Auth::id())
            ->where('role_has_users.roles_id','=',3) // Role 3 => superAdmin
            ->first();

         if(!empty($role))
         {
         	return 1;
         }


           return 0;

	}
}


if(!function_exists('getUserRole'))
{
	function getUserRole($idUser)
	{
		$role = DB::table('role_has_users')
            ->join('roles', 'roles.id', '=', 'role_has_users.roles_id')
            ->select('roles.*','roles.id as roleId')
            ->where('role_has_users.user_id','=', $idUser)
            ->first();

           return $role;
	}
}


if(!function_exists('allRole'))
{
	function allRole()
	{
		$role = DB::table('roles')->orderBy('id','desc')->get();
           return $role;
	}
}



if(!function_exists('allUser'))
{
	function allUser()
	{
		$user = DB::table('users')->orderBy('id','desc')->get();
           return $user;
	}
}

if(!function_exists('hasStatAccesto'))
{
	function hasStatAccesto($user_id,$acces_id)
	{
		$nb = user_has_acces::where("user_id","=",$user_id)->where("acces_id","=",$acces_id)->get();

			if (count($nb) == 0) 
			{
				return 0;
			}
			else
			{

				return $nb->first()->status;
			}
           
	}
}

//Retourne le forfait d'abonnement actif du connecte
if(!function_exists('getAbnmnt'))
{
	function getAbnmnt()
	{
		 $abmnt =  DB::table('abonnements')
            ->join('offres', 'offres.id', '=', 'abonnements.offres_id')
            ->select('offres.*','abonnements.*')
            ->where('abonnements.statuPaiement','=', 1)
            ->first();
		 return $abmnt;
           
	}
}

//Retourne le dernier abonnement ayant expirer
if(!function_exists('getLastAbnmnt'))
{
	function getLastAbnmnt()
	{
		 $abmnt =  DB::table('abonnements')
            ->join('offres', 'offres.id', '=', 'abonnements.offres_id')
            ->select('offres.*','abonnements.*')
            ->where('abonnements.statuPaiement','=', 0)
			->orderBy('abonnements.id','desc')
            ->first();
		 return $abmnt;
           
	}
}

//Verifie si le forfait actif ou le dernier forfai est essaie
if(!function_exists('isEssaie'))
{
	function isEssaie()
	{
		$lastAbn = is_null(getAbnmnt()) ? getLastAbnmnt(): getAbnmnt();

		if($lastAbn->libele == "essaie")
		{
		 return 1;
		}
		else
		{
		 return 0;
		}
           
	}
}

//Retourne les info dune offre d'abonnement
    if(!function_exists('getForfait'))
	{
		function getForfait($id)
		{
			
			$offres = offres::find($id);
			return $offres;
		}
	}
//Retourne tous les abonnement du connecte
if(!function_exists('allAbnmnt'))
{
	function allAbnmnt()
	{
		 $abmnt =  DB::table('abonnements')
            ->join('offres', 'offres.id', '=', 'abonnements.offres_id')
            ->select('offres.*','abonnements.*')
            ->orderBy('abonnements.id','desc')->get();
		 return $abmnt;
           
	}
}



//Retrouver la succu  a partir du gerant connecte 
if(!function_exists('userHasSucc'))
{
	function userHasSucc($user_id)
	{
		$suc = succursale::where("user_id","=",$user_id)->get();
			if (count($suc) == 0) 
			{
				return 0;
			}
			else
			{

				return $suc->first();
			}
	}
           

}







