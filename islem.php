<?php
    ob_start();
    session_start();
    include 'baglan.php';
    $kullanicisor = $db->prepare("SELECT * FROM hasta WHERE TCKN=:TCKN");
    $kullanicisor->execute([
        'TCKN' => $_SESSION['TCKN']
    ]);
    $say=$kullanicisor->rowCount();
    $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
///////////////////////////////////////////////////////////////////////////////
    $doktorsor=$db->prepare("SELECT * FROM doktor WHERE TCKN=:TCKN");
    $doktorsor->execute([
        'TCKN' => $_SESSION['userTCKN']
        
    ]);
    $saydktr=$doktorsor->rowCount();
    $doktorcek=$doktorsor->fetch(PDO::FETCH_ASSOC);
    

    if(isset($_POST['kullanicikaydet'])){
        $TCKN = isset($_POST['TCKN']) ? $_POST['TCKN'] : null;
        $Sifre = isset($_POST['Sifre']) ? $_POST['Sifre'] : null;
        $DogumYeri = isset($_POST['DogumYeri']) ? $_POST['DogumYeri'] : null;
        $Ad = isset($_POST['Ad']) ? $_POST['Ad'] : null;
        $Soyad = isset($_POST['Soyad']) ? $_POST['Soyad'] : null;
        $Cinsiyet = isset($_POST['Cinsiyet']) ? $_POST['Cinsiyet'] : null;
        $Adres = isset($_POST['Adres']) ? $_POST['Adres'] : null;
        $KanGrubu = isset($_POST['KanGrubu']) ? $_POST['KanGrubu'] : null;
        $MedeniDurum = isset($_POST['MedeniDurum']) ? $_POST['MedeniDurum'] : null;
        $Meslek = isset($_POST['Meslek']) ? $_POST['Meslek'] : null;
        $EgitimDurum = isset($_POST['EgitimDurum']) ? $_POST['EgitimDurum'] : null;
        $DogumTarihi = isset($_POST['DogumTarihi']) ? $_POST['DogumTarihi'] : null;
        $TelNo = isset($_POST['TelNo']) ? $_POST['TelNo'] : null;
        

        $sorgu = $db->prepare('INSERT INTO hasta SET
            TCKN = ?,
            Sifre = ?,
            DogumYeri = ?,
            Ad = ?,
            Soyad =?,
            Cinsiyet = ?,
            Adres = ?,
            KanGrubu = ?,
            MedeniDurum = ?,
            Meslek = ?,
            EgitimDurum = ?,
            DogumTarihi = ?,
            TelNo=?
            
        ');
        $ekle = $sorgu->execute([
            $TCKN, $Sifre, $DogumYeri, $Ad, $Soyad, $Cinsiyet, $Adres, $KanGrubu, $MedeniDurum, $Meslek,$EgitimDurum,$DogumTarihi, $TelNo
        ]);
        if($ekle){
            header('location:index.php?durum:basarili');
        }else{
            $hata = $sorgu->errorInfo();
            echo 'mysql hatası' .$hata[2]; 
        }

    }

    if(isset($_POST['giris_yap'])){
        $TCKN = $_POST['TCKN'];
        $Sifre = $_POST['Sifre'];

        $kullanicisor= $db->prepare("SELECT * FROM hasta WHERE TCKN=:TCKN and Sifre=:Sifre");
        $kullanicisor->execute([
            'TCKN' => $TCKN,
            'Sifre' => $Sifre

        ]);

        $say = $kullanicisor->rowCount();
        if($say==1){
            $_SESSION['userTCKN'] = $TCKN;
            header('location:anasayfa.php?durum=girisbasarili');
            exit;
        }else{
            header('location:index.php?durum=basarisizgiris');
            exit;
        }
    }
    if(isset($_POST['giris_yap_doktor'])){
        $TCKN = $_POST['TCKN'];
        $Sifre = $_POST['Sifre'];

        $doktorsor= $db->prepare("SELECT * FROM doktor WHERE TCKN=:TCKN and Sifre=:Sifre");
        $doktorsor->execute([
            'TCKN' => $TCKN,
            'Sifre' => $Sifre

        ]);

        $saydktr = $doktorsor->rowCount();
        if($saydktr==1){
            $_SESSION['userTCKN'] = $TCKN;
            header('location:doktoranasayfa.php?durum=girisbasarili');
            exit;
        }else{
            header('location:doktorgiris.php?durum=basarisizgiris');
            exit;
        }
    }

    if(isset($_POST['randevu_kaydet'])) {

        $Poliklinik = isset($_POST['Klinik']) ? $_POST['Klinik'] : null;
        $RandevuTarihiVeSaati = isset($_POST['Tarih']) ? $_POST['Tarih'] : null;
        $Sehir = isset($_POST['Sehir']) ? $_POST['Sehir'] : null;
        $Hastane = isset($_POST['Hastane']) ? $_POST['Hastane'] : null;
        $Doktor = isset($_POST['Doktor']) ? $_POST['Doktor'] : null;
        


        $kaydet=$db->prepare("INSERT INTO randevu SET

            Poliklinik = ?,
            RandevuTarihiVeSaati =?,
            Sehir=?,
            Hastane=?,
            Doktor=?,
            
            
            
            
            

        ");

        $insert=$kaydet->execute([
            $Poliklinik,$RandevuTarihiVeSaati,$Sehir,$Hastane,$Doktor
        ]);

        if($insert){
            header("location:anasayfa.php?kayit_basarili");
        }else{
            header("location:anasayfa.php?kayit_basarisiz");
        }


    }
    if($_POST["Guncelle"]){       
                    
        $query = $db->prepare("UPDATE hasta SET Ad=:Ad, Soyad=:Soyad, DogumTarihi=:DogumTarihi, MedeniDurum=:MedeniDurum, Cinsiyet=:Cinsiyet, Adres=:Adres, Kangrubu=:KanGrubu, TelNo=:TelNo, Meslek=:Meslek, EgitimDurum=:EgitimDurum WHERE TCKN=:TCKN");
        $deneme=$query->execute(array(
            "Ad" => $_POST["Ad"],
            "Soyad" => $_POST["Soyad"],
            "DogumYeri" => $_POST["DogumYeri"],
            "Cinsiyet" => $_POST["Cinsiyet"],
            "Adres" => $_POST["Adres"],
            "KanGrubu" => $_POST["KanGrubu"],
            "MedeniDurum" => $_POST["MedeniDurum"],
            "Meslek" => $_POST["Meslek"],
            "EgitimDurum" => $_POST["EgitimDurum"],
            "DogumTarihi" => $_POST["DogumTarihi"],
            "TelNo" => $_POST["TelNo"],
            "TCKN" =>$_GET["TCKN"]

        ));

        if($deneme){
            header("location:anasayfa.php?guncelleme_basarili");
        }else{
            header("location:anasayfa.php?guncelleme_basarisiz");
        }

    }
    if(isset($_POST['tani_gir'])){
        $TaniKod = isset($_POST['TaniKod']) ? $_POST['TaniKod'] : null;
        $TaniAd = isset($_POST['TaniAd']) ? $_POST['TaniAd'] : null;  

        $kaydet=$db->prepare("INSERT INTO tani SET

            TaniKod = ?,
            TaniAd =?           
        ");
         $insert=$kaydet->execute([
            $TaniKod,$TaniAd
        ]);

        if($insert){
            header("location:tani.php?kayit_basarili");
        }else{
            header("location:tani.php?kayit_basarisiz");
        }

    }
    if(isset($_POST['tetkik_gir'])){
        $TetkikKod = isset($_POST['TetkikKod']) ? $_POST['TetkikKod'] : null;
        $TetkikAd = isset($_POST['TetkikAd']) ? $_POST['TetkikAd'] : null;
        $Aciklama = isset($_POST['Aciklama']) ? $_POST['Aciklama'] : null;  
  
    
        $kaydet=$db->prepare("INSERT INTO tetkik SET

            TetkikKod = ?,
            TetkikAd =?,
            Aciklama=?           
        ");
         $insert=$kaydet->execute([
            $TetkikKod,$TetkikAd,$Aciklama
        ]);

        if($insert){
            header("location:tetkik.php?kayit_basarili");
        }else{
            header("location:tetkik.php?kayit_basarisiz");
        }

    }
    if(isset($_POST['dosya_olustur'])){
        $HastaNo = isset($_POST['HastaNo']) ? $_POST['HastaNo'] : null;
        $TetkikKod = isset($_POST['TetkikKod']) ? $_POST['TetkikKod'] : null;
        $TaniKod = isset($_POST['TaniKod']) ? $_POST['TaniKod'] : null;
        $Recete = isset($_POST['Recete']) ? $_POST['Recete'] : null;
        $SigortaTuru = isset($_POST['SigortaTuru']) ? $_POST['SigortaTuru'] : null;  
  
    
        $kaydet=$db->prepare("INSERT INTO dosya SET
            HastaNo=?,
            TetkikKod = ?,
            TaniKod =?,
            Recete=?,
            SigortaTuru=?         
        ");
         $insert=$kaydet->execute([
            $HastaNo,$TetkikKod,$TaniKod,$Recete,$SigortaTuru
        ]);

        if($insert){
            header("location:dosya.php?kayit_basarili");
        }else{
            header("location:dosya.php?kayit_basarisiz");
        }

    }


?>