<?php 
class ExerciseVideosController extends \BaseController {

    public function removeVideo($id) {
        try {
                $res = -1;
                if (ExerciseVideos::destroy($id) ) {
                    $res = 1;
                } 

            return $res;
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

}


?>