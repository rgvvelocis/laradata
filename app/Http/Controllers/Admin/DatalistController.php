<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Hash;
use Auth;
use App\Models\Datalist;
use DB;
 

class DatalistController extends Controller
{
	
	public function __construct()
    {
        // Page Title
        $this->module_title = 'Data List';
        // module name
        $this->module_name = 'datalist';
		$this->model_name = 'App\Models\Datalist';
     
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(\Gate::allows($this->module_name.'_list'), 403);
		$module_title = $this->module_title;
        $module_name = $this->module_name;

        $name = $request->input('name');
        $designation = $request->input('designation');
        $company_name = $request->input('company_name');

       /*  foreach(Datalist::offset(8000)->limit(2000)->get() as $data)
        {
            $updateData = array(
				'name' =>  trim($data->name),
				'designation' => trim($data->designation),
				'company_name' => trim($data->company_name),
				'website' => trim($data->website),
				'address' => trim($data->address),				 
				'email' => trim($data->email),
				'office_contact' => trim($data->office_contact)				 
			);
		   
			$datalist = Datalist::where('id',$data->id)->update($updateData);
		    $this->generateimage1($data->id);
        }
        die('Done'); */ 
        
        
        $list = Datalist::query();

        // Apply filters if they are present
        if ($name) {
            $list->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%')->Orwhere('email', 'like', '%' . $name . '%');
            });
        }
    
        if ($designation) {
            $list->where('designation', 'like', '%' . $designation . '%');
        }
    
        if ($company_name) {
            $list->where('company_name', 'like', '%' . $company_name . '%');
        }
    
        // Paginate the filtered results
        $list = $list->paginate(10);
        DB::disconnect();       
        return view("admin.datalist.index",compact('list',"module_title", "module_name"))
            ->with('i', ($request->input('page', 1) - 1) * 10);
			
		 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows($this->module_name.'_create'), 403);
		$module_title = $this->module_title;
        $module_name = $this->module_name;
		return view('admin.datalist.create', compact('module_title', 'module_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(\Gate::allows($this->module_name.'_create'), 403);
        $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'company_name' => 'required',
            'website' => 'required',
            'address' => 'required',
            'email' => 'required',
            'office_contact' => 'required',
        ]);
		
		$insertData = array(
				'name' =>  $request->name,
				'designation' => $request->designation,
				'company_name' => $request->company_name,
				'website' => $request->website,
				'address' => $request->address,				 
				'email' => $request->email,
				'office_contact' => $request->office_contact
			);
		    
			$data = Datalist::create($insertData);
			$this->generateimage1($data->id);
		 Alert::success('Success', 'Data created successfully');
         return redirect()->route('admin.datalist.index')->with('loader', true);
		 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows($this->module_name.'_edit'), 403);
		$module_title = $this->module_title;
        $module_name = $this->module_name;
        $datalist = Datalist::find($id); 
        return view('admin.datalist.edit',compact('datalist','module_title', 'module_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_unless(\Gate::allows($this->module_name.'_edit'), 403);
        $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'company_name' => 'required',
            'website' => 'required',
            'address' => 'required',
            'email' => 'required',
            'office_contact' => 'required',
        ]);
		
			$updateData = array(
				'name' =>  $request->name,
				'designation' => $request->designation,
				'company_name' => $request->company_name,
				'website' => $request->website,
				'address' => $request->address,				 
				'email' => $request->email,
				'office_contact' => $request->office_contact				 
			);
		   
			$datalist = Datalist::find($id);		 
			$datalist->update($updateData);
			$this->generateimage1($id);
		 
		
		 Alert::success('Success', 'Data updated successfully');
         return redirect()->route('admin.datalist.index')->with('loader', true);
		 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows($this->module_name.'_delete'), 403);
        Datalist::where('id',$id)->delete();
		Alert::success('Success', 'Data deleted successfully');
         return redirect()->route('admin.datalist.index')->with('loader', true);
         
    }
    
    public function generateimage1($param, $data = '') {
    // Increase image width for more right-side space
    $im = imagecreatetruecolor(700, 150); // Increased width from 620 to 700

    // Define colors
    $white = imagecolorallocate($im, 255, 255, 255);
    $black = imagecolorallocate($im, 0, 0, 0);
    imagefilledrectangle($im, 0, 0, 700, 150, $white); // Fill with white background

    // Fetch data from database
    $data1 = Datalist::where('id', $param)->first();
    $img_name = $param . '.jpg';

    // Update database with image name
    Datalist::where('id', $param)->update(['create_image' => $img_name]);

    // Construct the text content
    $text = $data1['name'] . " * " . 
            $data1['designation'] . " * " . 
            $data1['company_name']. " * " . 
            $data1['website']. " * " . 
            $data1['address']. " * " . 
            $data1['email']. " * " . 
            $data1['office_contact'];

    // Set font path
    $font = public_path('/YanoneKaffeesatz-Light.ttf');

    // Increase max characters per line for wider space
    $break = 70;  // Increased from 70 to 80 characters per line

    // Wordwrap text and split into lines
    $wrappedText = wordwrap($text, $break, "\n");  
    $lines = explode("\n", $wrappedText);  

    // Positioning variables
    $fontSize = 18;
    $x = 20; // Increased left padding for better spacing
    $y = 30;
    $lineSpacing = 25;  // Adjust line spacing

    // Write each line on the image
    foreach ($lines as $line) {
        imagettftext($im, $fontSize, 0, $x, $y, $black, $font, $line);
        $y += $lineSpacing;
    }

    // Output the image
    header('Content-Type: image/jpeg');
    imagejpeg($im, 'public/admin/data_image/' . $param . '.jpg');
    
    // Free up memory
    imagedestroy($im);

    return true;
}


	
	public function generateimage1_($param, $data = '') {

        // Create the image
        $im = imagecreatetruecolor(620, 150);
        // Create some colors
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 128, 128, 128);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 620, 150, $white);
        //$data1 = $this->db->query("SELECT * FROM `dt_creator` where creator_id=" . $param)->row_array();
		$data1 = Datalist::where('id',$param)->first();
        $img_name = $param . '.jpg';
        //$query = $this->db->update('dt_creator', array('create_image' => $img_name), array('creator_id' => $param));
		$query = Datalist::where('id',$param)->update(['create_image' => $img_name]);
        // The text to draw
        $text = $data1['name'] . " * " . 
                $data1['designation'] . " * " . 
                $data1['company_name']. " * " . 
                $data1['website']. " * " . 
                $data1['address']. " * " . 
                $data1['email']. " * " . 
                $data1['office_contact'];
        // Replace path by your own font path
        $font = public_path('/YanoneKaffeesatz-Light.ttf');
		//die;
        $break = 70;
        //$new_text = implode(PHP_EOL, str_split($text, $break));

        //$new_text = str_split($text, $split_length = 70);
        $str = wordwrap($text, $break);
		$str = explode("\n", $str);	 
		
        $new_text = implode(PHP_EOL, $str);

        imagettftext($im, 18, 0, 10, 30, $black, $font, $new_text);
        // Using imagepng() results in clearer text compared with imagejpeg()
        header('Content-Type: image/jpeg');
        imagejpeg($im, 'public/admin/data_image/' . $param . '.jpg');
        imagedestroy($im);
        return true;
    }
}
