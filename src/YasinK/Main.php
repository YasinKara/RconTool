<?php

namespace YasinK;

use Thedudeguy\Rcon;

class Main{

    public function __construct(){
        $this->start();
    }

    public function start() : void{
        if (file_exists(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'config.json')){
            while(true){
                RETRY:
                $color = new Colors;
                $config = json_decode(file_get_contents(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . "config.json"));
                echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" Bir sunucu seçiniz ; ","dark_gray");
                foreach ($config->sunucular as $server) {
                    echo $color->makeColor("\n>","yellow") . $color->makeColor(" $server\n","white");
                }
                $get = trim(fgets(STDIN));
                if (in_array($get,$config->sunucular)){
                    $sunucu = json_decode(file_get_contents(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . "Sunucular/$get.json"));
                    echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" Sunucuya gönderilecek komutu yazın\n ","dark_gray");
                    $get = trim(fgets(STDIN));
                    if (empty($get)) echo $color->makeColor("Bir komut girin\n","white","red");
                    else{
                        $rcon = new Rcon($sunucu->ip, $sunucu->port, $sunucu->pass, 3);
                        $rcon->sendCommand("$get");
                        if ($rcon->connect()) {
                            $rcon->sendCommand("$get");
                            echo $color->makeColor("Komut başarıyla yollandı\n","white","green");
                        }else{
                            echo $color->makeColor("Sunucuya erişilemiyor\n","white","red");
                            exit(1);
                        }
                    }
                }else echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" Böyle bir sunucu eklememişsiniz\n","dark_gray");
            }
        }else{
            while(true){
                AGAIN:
                $color = new Colors;
                $name = null;
                $ip = null;
                $port = null;
                $pass = null;
                echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" RCON sunucunuz bulunmamaktadır, ilk sunucuna ad vermeye ne dersin ? ","dark_gray");
                $get = trim(fgets(STDIN));
                if (empty($get)) echo "Bir isim girmelisin";
                else{
                    $name = $get;
                    echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" Şimdi sunucunun ip adresini yaz ","dark_gray");
                    $get = trim(fgets(STDIN));
                    if (empty($get)) echo "Bir IP girmelisin";
                    else{
                        $ip = $get;
                        echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" Şimdi sunucunun portunu yaz ","dark_gray");
                        $get = trim(fgets(STDIN));
                        if (empty($get)) echo "Bir PORT girmelisin";
                        else{
                            $port = $get;
                            echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" Şimdi sunucunun şifresini yaz ","dark_gray");
                            $get = trim(fgets(STDIN));
                            if (empty($get)) echo "Bir PASSWORD girmelisin";
                            else{
                                $pass = $get;
                                echo $color->makeColor("\n[" . date("H:i:s") . "]" . "[Rcon Tool]","yellow") . $color->makeColor(" =>","light_blue") . $color->makeColor(" Sunucu oluşturuldu \n","green");
                                $array = array(
                                   "isim" => $name,
                                    "ip" => $ip,
                                    "port" => $port,
                                    "pass" => $pass
                                );
                                @mkdir(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . "Sunucular");
                                $this->createFile($name, $array, "json","Sunucular/");
                                $json = array(
                                    "sunucular" => [
                                   "$name"
                                ]
                                );
                                $this->createFile("config",$json,"json");
                                exit(1);
                            }
                        }
                    }
                }
            }
        }
    }

    public function createFile($name, $text, $type, $way = null) {
        $dosya = fopen(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . "$way$name.$type", 'w');
        if ($type == "json") fwrite($dosya, json_encode($text));
        else fwrite($dosya, $text);
        fclose($dosya);
    }

 }