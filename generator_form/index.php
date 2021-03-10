<?php
/**
 * 
 * Author    : Fauzan Falah ( Anang )
 * File      : index.php
 * Web Name  : Codekop CRUD HTML Generator with Bootstrap 4
 * Version   : v1.0.0
 * Website   : https://www.codekop.com/
 * Facebook  : https://www.facebook.com/fauzan.falah2  
 * HP/WA	 : 089618173609
 * E-mail 	 : codekop157@gmail.com / fauzancodekop@gmail.com / fauzan1892@codekop.com
 * 
 * 
 */
    error_reporting(1);
    if(!empty($_GET['get']))
    {
        // koneksi antar database ---
        $dbhost = $_POST['host']; // set the hostname
        $dbname = $_POST['dbname']; // set the database name
        $dbuser = $_POST['user']; // set the mysql username
        $dbpass = $_POST['pass'];  // set the mysql password

        try {
            $koneksi = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $koneksi->exec("set names utf8");
            $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            return 'Connection failed : ' . $e->getMessage();
        }

        // https://stackoverflow.com/questions/5428262/php-pdo-get-the-columns-name-of-a-table
       
        // table sql ---
        $table = $_POST['table'];
        $kolom = $koneksi->prepare("SELECT * FROM $table LIMIT 0");
        $kolom->execute();

        // basic form ---
        if(!empty($_POST['category'] == '1'))
        {
            // for basic form ---
            for ($i = 0; $i < $kolom->columnCount(); $i++) {
                $col = $kolom->getColumnMeta($i);
                $col['name'];
                // echo $col['native_type'].' =>'.$col['name'].'<br>';
                $label = ucfirst(preg_replace('/[^a-zA-Z0-9\']/', ' ', $col['name']));
                
                //tipe kolom
                if($col['native_type'] == 'LONG')
                {
                    $type = 'number';
                }else if($col['native_type'] == 'BLOB'){
                    $type = 'textarea';
                }else if($col['native_type'] == 'DATE'){
                    $type = 'date';
                }else if($col['native_type'] == 'TIMESTAMP'){
                    $type = 'datetime-local';
                }else{
                    $type = 'text';
                }

            // tipe pakai laravel ---
            if(($_POST['type'] == '4'))
            {
                // tipe input pakai laravel ---
                if($type == 'textarea')
                {
                    $inputmode = '<textarea class="form-control @error("'.$col['name'].'") is-invalid @enderror" name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">{{old("'.$col['name'].'")}}</textarea>';
                    $inputmode_update = '<textarea class="form-control @error("'.$col['name'].'") is-invalid @enderror" name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">{{$edit->'.$col['name'].')}}</textarea>';
                }else{
                    $inputmode = '<input type="'.$type.'" class="form-control @error("'.$col['name'].'") is-invalid @enderror" value="{{old("'.$col['name'].'")}} name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">';
                    $inputmode_update = '<input type="'.$type.'" class="form-control @error("'.$col['name'].'") is-invalid @enderror" value="{{$edit->'.$col['name'].')}} name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">';
                }
            }else{

                // tipe input pakai codeigniter 3 ---
                if($type == 'textarea')
                {
                    $inputmode = '<textarea class="form-control" name="'.$col['name'].'" id="'.$col['name'].'" placeholder=""></textarea>';
                    $inputmode_update = '<textarea class="form-control" name="'.$col['name'].'" id="'.$col['name'].'" placeholder=""><?= $edit->'.$col['name'].';?></textarea>';
                }else{
                    $inputmode = '<input type="'.$type.'" class="form-control" name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">';
                    $inputmode_update = '<input type="'.$type.'" class="form-control" value="<?= $edit->'.$col['name'].';?>" name="'.$col['name'].'" id="'.$col['name'].'" placeholder=""/>';
                }
            }
            
// kode result laravel ---
if(($_POST['type'] == '4'))
{
    // kode result html laravel ---
    $html_code .= '<div class="form-group">
        <label for="">'.$label.'</label>
        '.$inputmode.'
        @error("'.$col['name'].'")
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
';
}else{
    // kode result codeigniter 3 ---
    $html_code .= '<div class="form-group">
        <label for="">'.$label.'</label>
        '.$inputmode.'
    </div>
    ';
    $html_code_update .= '<div class="form-group">
        <label for="">'.$label.'</label>
        '.$inputmode_update.'
    </div>
    ';
}
            } 
            // for basic form ---

        }else{
            // for horizontal form ---
            for ($i = 0; $i < $kolom->columnCount(); $i++) {
                $col = $kolom->getColumnMeta($i);
                $col['name'];
                // echo $col['native_type'].' =>'.$col['name'].'<br>';
                $label = ucfirst(preg_replace('/[^a-zA-Z0-9\']/', ' ', $col['name']));
                
                //tipe kolom
                if($col['native_type'] == 'LONG')
                {
                    $type = 'number';
                }else if($col['native_type'] == 'BLOB'){
                    $type = 'textarea';
                }else if($col['native_type'] == 'DATE'){
                    $type = 'date';
                }else if($col['native_type'] == 'TIMESTAMP'){
                    $type = 'datetime-local';
                }else{
                    $type = 'text';
                }

                // tipe pakai laravel ---
                if(($_POST['type'] == '4'))
                {
                    // tipe pakai input laravel ---
                    if($type == 'textarea')
                    {
                        $inputmode = '<textarea class="form-control @error("'.$col['name'].'") is-invalid @enderror" name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">{{old("'.$col['name'].'")}}</textarea>';
                        $inputmode_update = '<textarea class="form-control @error("'.$col['name'].'") is-invalid @enderror" name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">{{$edit->'.$col['name'].')}}</textarea>';
                    }else{
                        $inputmode = '<input type="'.$type.'" class="form-control @error("'.$col['name'].'") is-invalid @enderror" value="{{old("'.$col['name'].'")}} name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">';
                        $inputmode_update = '<input type="'.$type.'" class="form-control @error("'.$col['name'].'") is-invalid @enderror" value="{{$edit->'.$col['name'].')}} name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">';
                    }
                }else{
                    // tipe pakai input codeigniter 3 ---
                    if($type == 'textarea')
                    {
                        $inputmode = '<textarea class="form-control" name="'.$col['name'].'" id="'.$col['name'].'" placeholder=""></textarea>';
                        $inputmode_update = '<textarea class="form-control" name="'.$col['name'].'" id="'.$col['name'].'" placeholder=""><?= $edit->'.$col['name'].';?></textarea>';
                    }else{
                        $inputmode = '<input type="'.$type.'" class="form-control" name="'.$col['name'].'" id="'.$col['name'].'" placeholder="">';
                        $inputmode_update = '<input type="'.$type.'" class="form-control" value="<?= $edit->'.$col['name'].';?>" name="'.$col['name'].'" id="'.$col['name'].'" placeholder=""/>';
                    }
                    
                }

// result kode html create horizontal form ---
$html_code .= '<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label">'.$label.'</label>
    <div class="col-sm-9">
        '.$inputmode.'
    </div>
</div>
';
// result kode html update horizontal form ---
$html_code_update .= '<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label">'.$label.'</label>
    <div class="col-sm-9">
        '.$inputmode_update.'
    </div>
</div>
';
            }
        }
        if(!empty($_POST['category'] == '1'))
        {
            // button tipe left
            $button  = '<button class="btn btn-primary btn-md">Save</button>';
        }else{
            // button tipe right
            $button  = '<button class="btn btn-primary btn-md float-right">Save</button>';
        }

        // array from CRUD
        if(!empty($_POST['array'] == '2'))
        {
$html_array .= '<?php
$data = [
    ';
            for ($i = 0; $i < $kolom->columnCount(); $i++) {
                $col = $kolom->getColumnMeta($i);
                $col['name'];
                // echo $col['native_type'].' =>'.$col['name'].'<br>';
                $label = ucfirst(preg_replace('/[^a-zA-Z0-9\']/', ' ', $col['name']));
                
$html_array .= "    '".$col['name']."' => //your_post 
    ";   
   

            }
$html_array .= '];';
        }else{
            $html_array = 'No Result';
        }
?>

<?php
    //  start CRUD Codeigniter 3 ---
    if(!empty($_POST['type'] == '2'))
    {
            
$html_insert .= '<?php 
public function store()
{
    ';
$html_update .= '<?php
public function update()
{
$id =  strip_tags($this->input->post("id")); // parameter yang mau di update
    ';
$html_delete .= '<?php 
public function delete()
{
    $id = strip_tags($this->input->get("id"));
    $cek = $this->db->get_where("'.$table.'",["" => $id]); // tulis id yang dituju
    if($cek->num_rows() > 0)
    {
        $this->db->where("id",$id); // tulis id yang dituju
        $this->db->delete("'.$table.'");
        $this->session->set_flashdata("success"," Berhasil Delete Data ! ");
        redirect(base_url("'.$table.'"));
    }else{
        $this->session->set_flashdata("failed"," Gagal Delete Data ! ".validation_errors());
        redirect(base_url("'.$table.'"));
    }
}
    ';
        // for kolom codeigniter 3 ---
        for ($i = 0; $i < $kolom->columnCount(); $i++) {
            $col = $kolom->getColumnMeta($i);
            $col['name'];
            // echo $col['native_type'].' =>'.$col['name'].'<br>';
            $label = ucfirst(preg_replace('/[^a-zA-Z0-9\']/', ' ', $col['name']));

$html_insert .= '
$this->form_validation->set_rules("'.$col['name'].'", "'.$label.'", "required");';  
$html_update .= '
$this->form_validation->set_rules("'.$col['name'].'", "'.$label.'", "required");'; 

        }

$html_insert .= '
if($this->form_validation->run() != false) {
    
$data = [
    ';
$html_update .= '
if($this->form_validation->run() != false) {

$data = [
    ';
        // for kolom codeigniter 3 ---
        for ($i = 0; $i < $kolom->columnCount(); $i++) {
            $col = $kolom->getColumnMeta($i);
            $col['name'];
            // echo $col['native_type'].' =>'.$col['name'].'<br>';
            $label = ucfirst(preg_replace('/[^a-zA-Z0-9\']/', ' ', $col['name']));

$html_insert .= "    '".$col['name']."' => ".'htmlspecialchars($this->input->post("'.$col['name'].'", TRUE) ,ENT_QUOTES),
    ';   
$html_update .= "    '".$col['name']."' => ".'htmlspecialchars($this->input->post("'.$col['name'].'", TRUE) ,ENT_QUOTES),
    ';  
   

            }
$html_insert .= '];
$this->db->insert("'.$table.'", $data);
$this->session->set_flashdata("success"," Berhasil Insert Data ! ");
redirect(base_url("'.$table.'"));

}else{
    $this->session->set_flashdata("failed"," Gagal Insert Data ! ".validation_errors());
    redirect(base_url("'.$table.'"));
}
}';
$html_update .= '];
$this->db->where("id", $id); // ubah id dan postnya
$this->db->update("'.$table.'", $data);
$this->session->set_flashdata("success"," Berhasil Update Data ! ");
redirect(base_url("'.$table.'"));

}else{
    $this->session->set_flashdata("failed"," Gagal Update Data ! ".validation_errors());
    redirect(base_url("'.$table.'"));
}
}';
    }
}
    // end crud CodeIgniter 3 ---
?>

<?php 
    // start crud Laravel ---
    if(!empty($_POST['type'] == '4'))
    {

$html_insert .= '<?php 
public function store(request $request)
{
    $validator = \Validator::make($request->all(),[
';
$html_update .= '<?php
public function update(request $request)
{
$id =  $request->get("id"); // parameter yang mau di update
$validator = \Validator::make($request->all(),[
';
$html_delete .= '<?php 
public function delete()
{
$id =  $request->get("id"); // parameter yang mau di update
$cek = DB::table("'.$table.'")->where(["id" => $id])->first(); // tulis id yang dituju
if($cek->num_rows() > 0)
{
 $DB::table("'.$table.'")->where(["id" => $id])->delete();
 return redirect(url())->with("success"," Berhasil Delete Data ! ");
 }else{
 return redirect()->back()
 ->withErrors($validator)
 ->with("failed"," Gagal Delete Data ! ");
}
}
';
    // for kolom crud laravel --
    for ($i = 0; $i < $kolom->columnCount(); $i++) {
        $col = $kolom->getColumnMeta($i);
        $col['name'];
        // echo $col['native_type'].' =>'.$col['name'].'<br>';
        $label = ucfirst(preg_replace('/[^a-zA-Z0-9\']/', ' ', $col['name']));

$html_insert .= '
    "'.$col['name'].'" => "required",
';  
$html_update .= '
"'.$col['name'].'" => "required",

';  

    }

$html_insert .= '
]);
if($validator->passes())
{

DB::table("'.$table.'")->insert([
';
$html_update .= '
]);
    "'.$col['name'].'" => "required",
if($validator->passes())
{
DB::table("'.$table.'")->where("id",$id)->update([
';

    // for kolom crud laravel --
    for ($i = 0; $i < $kolom->columnCount(); $i++) {
        $col = $kolom->getColumnMeta($i);
        $col['name'];
        // echo $col['native_type'].' =>'.$col['name'].'<br>';
        $label = ucfirst(preg_replace('/[^a-zA-Z0-9\']/', ' ', $col['name']));

$html_insert .= "    '".$col['name']."' => ".'$request->get("'.$col['name'].'"),
';   
$html_update .= "    '".$col['name']."' => ".'$request->get("'.$col['name'].'"),
';  

    }

$html_insert .= '
]);
return redirect(url())->with("success"," Berhasil Insert Data ! ");
}else{
return redirect()->back()
->withErrors($validator)
->with("failed"," Gagal Insert Data ! ");
}
}';
$html_update .= '
]);
return redirect(url())->with("success"," Berhasil Update Data ! ");
}else{
return redirect()->back()
->withErrors($validator)
->with("failed"," Gagal Update Data ! ");
}
}';

    }

    // end crud laravel --
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Generator Bootstrap</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="prism.css"/>
    </head>
    <body>
        <div class="container mt-5 mb-5">
            <h3 class="text-center text-success"><b>Codekop CRUD HTML Generator dengan Bootstrap 4</b></h3>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header text-white bg-info">
                            <h5 class="card-title pt-2"><b>Atur Form PHP</b> <small class="pl-2">[ Aktifkan Web Server Anda ]</small></h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="index.php?get=proses">
                                <div class="form-group">
                                    <label for="">Host</label>
                                    <input type="text"
                                        class="form-control" 
                                        name="host" placeholder="localhost" value="localhost" required>
                                </div>
                                <div class="form-group">
                                    <label for="">User</label>
                                    <input type="text"
                                        class="form-control" 
                                        name="user" placeholder="root" value="root" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password"
                                        class="form-control" 
                                        name="pass" placeholder="Your Password">
                                </div>
                                <div class="form-group">
                                    <label for="">DB Name</label>
                                    <input type="text"
                                        class="form-control" 
                                        name="dbname" placeholder="Example : codekop_crud" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Table Name</label>
                                    <input type="text"
                                        class="form-control" 
                                        name="table" placeholder="Example : tbl_article" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Category Form</label>
                                    <select class="form-control" name="category" required>
                                        <option value="1">Basic form </option>
                                        <option value="2">Horizontal form</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Button Form</label>
                                    <select class="form-control" name="button" required>
                                        <option value="1">Button Left</option>
                                        <option value="2">Button Right</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Array Form CRUD</label>
                                    <select class="form-control" name="array" required>
                                        <option value="1">No</option>
                                        <option value="2">Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Type Framework / Native PHP</label>
                                    <select class="form-control" name="type" required>
                                        <option value="1">No</option>
                                        <option value="2">CodeIgniter 3</option>
                                        <option value="3" disabled>CodeIgniter 4</option>
                                        <option value="4">Laravel 6-8</option>
                                        <option value="5" disabled>PHP Native</option>
                                        <option value="6" disabled>Codekop 1</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-md">
                                    Submit
                                </button>
                                <a href="index.php" class="btn btn-danger btn-md">Reset</a>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <h5 class="card-title pt-2"><b>Display HTML</b></h5>
                        </div>
                        <div class="card-body">
                            <?= htmlspecialchars_decode($html_code);?><?= htmlspecialchars_decode($button);?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header text-white bg-info">
                            <h5 class="card-title pt-2"><b>Hasil Create</b></h5>
                        </div>
                        <div class="card-body">
                            <pre class="language-php"><code><?= htmlspecialchars($html_code);?><?= htmlspecialchars($button);?></code></pre>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header text-white bg-info">
                            <h5 class="card-title pt-2"><b>Hasil Update</b></h5>
                        </div>
                        <div class="card-body">
                            <pre class="language-php"><code><?= htmlspecialchars($html_code_update);?><?= htmlspecialchars($button);?></code></pre>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header text-dark bg-warning">
                            <h5 class="card-title pt-2"><b>Hasil Kode Array CRUD</b></h5>
                        </div>
                        <div class="card-body">
                            <pre class="language-php"><code><?= htmlspecialchars($html_array);?></code></pre>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header text-white bg-success">
                            <h5 class="card-title pt-2"><b>Hasil Kode Insert</b></h5>
                        </div>
                        <div class="card-body">
                            <pre class="language-php"><code><?= htmlspecialchars($html_insert);?></code></pre>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <h5 class="card-title pt-2"><b>Hasil Kode Update</b></h5>
                        </div>
                        <div class="card-body">
                            <pre class="language-php"><code><?= htmlspecialchars($html_update);?></code></pre>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header text-white bg-danger">
                            <h5 class="card-title pt-2"><b>Hasil Kode Delete</b></h5>
                        </div>
                        <div class="card-body">
                            <pre class="language-php"><code><?= htmlspecialchars($html_delete);?></code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="prism.js"></script>
    </body>
</html>