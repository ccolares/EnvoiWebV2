<?php

Class Media
{

    static public function upload($file, $dir, $type = 'img'){
            if($type == 'img'){
               return self::img_upload($file, $dir);
            }
            if($type == 'file'){
                return self::file_upload($file, $dir);
            }                   
    }

    static public function img_upload($file, $pasta = ''){
        // caso não for usado dentro de um foreach para as imagens
        $arquivo_tmp = $file['tmp_name'];
        $nome = $file['name'];
        if (!empty($nome) && !empty($arquivo_tmp)) {
            $ds = DIRECTORY_SEPARATOR;
            $dir = Path::base();
            $basepath = $dir . $ds . 'media' . $ds . $pasta;
            if (!is_dir("$basepath")) {
                @mkdir("$basepath", 0775);
            }else{
               @system("chmod -R 777 $basepath");
//                @chmod("$basepath", 775);
            }
            // Pega a extensão
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            // Converte a extensão para minúsculo
            $extensao = strtolower($extensao);
            // Somente imagens
            if (strstr('.jpg;.jpeg;.png;.gif', $extensao)) {
                // cria novo nome para a img
                $nome_arquivo = explode(".",$nome);
                $nome_arquivo[0] = str_replace('.', '-', $nome_arquivo[0]);
                $novoNome =  $nome_arquivo[0] . '-' . date('d-m-Y') . '-' .uniqid(time());
                $novoNome = Media::slug($novoNome)  . '.' . $extensao;
                // Concatena a pasta com o nome
                $destino = $basepath . $ds . $novoNome;
                // tenta mover o arquivo para o destino
                if(getimagesize($file["tmp_name"])) {
                    if (move_uploaded_file($arquivo_tmp, $destino)) {
                        // arquivo movido com sucesso
                        @system("chmod -R 755 $destino");
//                        @chmod("$destino", 775);
                        $tamanho = filesize($destino);
                        $data = (object) ['size' => $tamanho,'name' => $novoNome, 'ext' => $extensao, 'path' => $destino];
                        return $data;
                    }
                }
            } else {
                // formato nao permitido
//                return 1;
                exit;
            }
        } else {
//            return -1;
            exit;
        }
    }

    static public function img_upload_modulo($file, $modulo = '', $pasta = ''){
        // caso não for usado dentro de um foreach para as imagens
        $arquivo_tmp = $file['tmp_name'];
        $nome = $file['name'];
        if (!empty($nome) && !empty($arquivo_tmp)) {
            $ds = DIRECTORY_SEPARATOR;
            $dir = Path::base();

            $basepath = $dir . $ds . 'media' . $ds . $modulo;
            if (!is_dir("$basepath")) {
                @mkdir("$basepath", 0775);
            }else{
                @system("chmod -R 777 $basepath");
//                @chmod("$basepath", 775);
            }

            $basepath .= $ds . $pasta;
            if (!is_dir("$basepath")) {
                @mkdir("$basepath", 0775);
            }else{
                @system("chmod -R 777 $basepath");
//                @chmod("$basepath", 775);
            }
            // Pega a extensão
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            // Converte a extensão para minúsculo
            $extensao = strtolower($extensao);
            // Somente imagens
            if (strstr('.jpg;.jpeg;.png;.gif', $extensao)) {
                // cria novo nome para a img
                $nome_arquivo = explode(".",$nome);
                $nome_arquivo[0] = str_replace('.', '-', $nome_arquivo[0]);
                $novoNome =  $nome_arquivo[0] . '-' . date('d-m-Y') . '-' .uniqid(time());
                $novoNome = Media::slug($novoNome)  . '.' . $extensao;
                // Concatena a pasta com o nome
                $destino = $basepath . $ds . $novoNome;
                // tenta mover o arquivo para o destino
                if(getimagesize($file["tmp_name"])) {
                    if (move_uploaded_file($arquivo_tmp, $destino)) {
                        // arquivo movido com sucesso
                        @system("chmod -R 755 $destino");
//                        @chmod("$destino", 775);
                        $tamanho = filesize($destino);
                        $data = (object) ['size' => $tamanho,'name' => $novoNome, 'ext' => $extensao, 'path' => $destino];
                        return $data;
                    }
                }
            } else {
                // formato nao permitido
//                return 1;
                exit;
            }
        } else {
//            return -1;
            exit;
        }
    }


    static function slug($key, $nkey = null, $reverse = null) {
        $group_a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç',
            'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð',
            'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú',
            'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä',
            'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í',
            'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø',
            'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A', 'a', 'A',
            'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c',
            'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E',
            'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g',
            'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H',
            'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i',
            'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L',
            'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l',
            'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o',
            'O', 'o', 'O', 'o', '?', '?', 'R', 'r', 'R',
            'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's',
            '?', '?', 'T', 't', 'T', 't', 'T', 't', 'U',
            'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
            'U', 'u', 'W', 'w', 'Y', 'y', '?', 'Z', 'z',
            'Z', 'z', '?', '?', '?', '?', 'O', 'o', 'U',
            'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u',
            'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?',
            '?', '?', '?', '?', '?');
        $group_b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C',
            'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D',
            'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U',
            'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a',
            'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i',
            'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A',
            'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c',
            'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E',
            'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g',
            'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H',
            'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i',
            'I', 'i', '', '', 'J', 'j', 'K', 'k', 'L',
            'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l',
            'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
            'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R',
            'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's',
            'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U',
            'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
            'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z',
            'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U',
            'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u',
            'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A',
            'a', 'AE', 'ae', 'O', 'o');

        $pattern = array('/[^a-zA-Z0-9 -.]/', '/[ -]+/', '/^-|-$/');
        $replace = array(' ', '-', '');

        if ($reverse != null) {
            $replace = array('-', ' ', '');
        }
        $replaced = str_replace($group_a, $group_b, $key);
        return strtolower(Filter:: parse_string(preg_replace($pattern, $replace, $replaced)));
    }

    static public function img_rotaciona($img = null, $pasta = null){
        if(strlen($pasta) > 0 && strlen($img) > 0) {
            $dir = Path::base();
            $ds = DIRECTORY_SEPARATOR;
            $path = $dir . $ds . 'media' . $ds . $pasta . $ds . $img;
            list($width, $height, $image_type) = getimagesize($path);
            switch ($image_type)
            {
                case 1: $src = imagecreatefromgif($path); break;
                case 2: $src = imagecreatefromjpeg($path);  break;
                case 3: $src = imagecreatefrompng($path); break;
                default: return '';  break;
            }
            $tmp = imagerotate($src, -90, 0);
            ob_start();
            switch ($image_type)
            {
                case 1: imagegif($tmp); break;
                case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
                case 3: imagepng($tmp, NULL, 100); break; // no compression
                default: echo ''; break;
            }
            $final_image = ob_get_contents();
            $f = fopen("$path", "w");
            fwrite($f, $final_image);
            fclose($f);
            ob_end_clean(); // limpa o buffer de saida
            return 1;
        }else{
            return 0;
        }
    }

    static public function img_redimensiona($img = null, $pasta = null ,$quality = 70){
        if(strlen($pasta) > 0 && strlen($img) > 0) {
            $dir = Path::base();
            $ds = DIRECTORY_SEPARATOR;
            $path = $dir . $ds . 'media' . $ds . $pasta . $ds . $img;
            list($width, $height, $image_type) = getimagesize($path);
            switch ($image_type)
            {
                case 1: $src = imagecreatefromgif($path); break;
                case 2: $src = imagecreatefromjpeg($path);  break;
                case 3: $src = imagecreatefrompng($path); break;
                default: return '';  break;
            }
            ob_start();
            switch ($image_type)
            {
                case 1: imagegif($src); break;
                case 2: imagejpeg($src, NULL, $quality);  break;
                case 3: imagepng($src, NULL, $quality); break;
                default: echo ''; break;
            }
            $final_image = ob_get_contents();
            $f = fopen("$path", "w");
            fwrite($f, $final_image);
            fclose($f);
            ob_end_clean(); // limpa o buffer de saida
            $tamanho = filesize($path);
            return $tamanho;
        }else{
            return 0;
        }
    }

    static public function img_from_base64( $base64_string, $pasta = '', $tipo = 'jpg' ) {
        if(!isset($base64_string)){
            die("{\"error\": \" Sem o base_img\"}");
        }
        $ds = DIRECTORY_SEPARATOR;
        $dir = Path::base();
        $path = $dir . $ds . 'media' . $ds;
        $basepath = $path . $ds . $pasta;
        if (!is_dir("$basepath")) {
            @mkdir("$basepath", 0775);
        }else{
            @system("chmod -R 775 $basepath");
//            @chmod("$basepath", 775);
        }
        $nome = md5(uniqid(time())) . '.' . $tipo;
        $basepath = $basepath . $ds . $nome;
        $ifp = fopen( $basepath, 'wb' );
        $data = explode( ',', $base64_string );
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        fclose( $ifp );
        return $nome;
    }

    static public function file_upload($file, $pasta = ''){
        // caso não for usado dentro de um foreach para as imagens
         $arquivo_tmp = $file['tmp_name'];
         $nome = $file['name'];
        if (!empty($nome) && !empty($arquivo_tmp)) {
            $ds = DIRECTORY_SEPARATOR;
            $dir = Path::base();
            $basepath = $dir . $ds . 'media' . $ds . $pasta;
            if (!is_dir("$basepath")) {
                @mkdir("$basepath", 0777);
            }else{
                @system("chmod -R 777 $basepath");
//                @chmod("$basepath", 775);
            }
            // Pega a extensão
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            // Converte a extensão para minúsculo
            $extensao = strtolower($extensao);
            // Somente arquivos nos formatos permitidos
            if (strstr('.jpg;.jpeg;.png;.gif;.pdf;.doc;.docx;.xls;.xlx;.txt;.ppt;.pptx;.zip;.rar', $extensao)) {
                // cria novo nome para a img
                $nome_arquivo = explode(".",$nome);
                $nome_arquivo[0] = str_replace('.', '-', $nome_arquivo[0]);
                $novoNome =  $nome_arquivo[0] . '-' . date('d-m-Y') . '-' .uniqid(time());
                $novoNome = Media::slug($novoNome) . '.' . $extensao;
                // Concatena a pasta com o nome
                $destino = $basepath . $ds . $novoNome;
                // tenta mover o arquivo para o destino
                if (@move_uploaded_file($arquivo_tmp, $destino)) {
                    // arquivo movido com sucesso
                    @system("chmod -R 755 $destino");
//                    @chmod("$destino", 775);
                    $tamanho = filesize($destino);
                    $data = (object) ['size' => $tamanho,'name' => $novoNome, 'ext' => $extensao, 'path' => $destino];
                    return $data;
                }else{
                    echo -1;exit;
                }
            } else {
                // formato nao permitido
                echo 0;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }    

    static public function file_remove($file){
    }

    static public function dir_remove($directory) {
        if(is_dir($directory)) {
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory,FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $file){
                $file->isFile() ? unlink($file->getPathname()) : rmdir($file->getPathname());
            }
            rmdir($directory);
            return true;
        } else {
            return false;
        }
    }
}