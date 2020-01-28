<?php

namespace Views;

class View{

    public function generate($_view, $datas = null)
    {
        if(file_exists($_view))
        {
            // On rend dispo toutes les entrées du tableau $data sous forme de variable
            extract($datas);
            if (is_array($datas)) extract($datas);
            ob_start();

            include ($_view);

            $content = ob_get_clean();

            return $content;
        } else{
            throw new \Exception("Vue $_view non trouvée");
        }

    }
}