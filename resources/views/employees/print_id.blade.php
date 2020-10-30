@php
    Fpdf::AddPage("P", [53.98,85.60]);
    Fpdf::SetMargins(0,0,0,0);
    Fpdf::SetAutoPageBreak(false);
    
    Fpdf::SetFont('Courier', 'B', 18);
    
    if (file_exists( public_path() . '/id_image/employee_image/' . $employee->id . '.png')){
        
        $image = public_path() . '/id_image/employee_image/' . $employee->id . '.png';
        $destinationPath = public_path('/id_image/temp_employee_image/');

        if(!File::isDirectory($destinationPath)){
            File::makeDirectory($destinationPath, 0777, true, true);
        }
        
        $img = Image::make(file_get_contents($image));

        $img->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'. $employee->id . '.png');

        if (file_exists( public_path() . '/id_image/temp_employee_image/' . $employee->id . '.png')){
            Fpdf::Image(url("/id_image/temp_employee_image/") .'/'. $employee->id.'.png', 12.5, 20, 29, 29,'PNG');
        }
    }
   
    if (file_exists( public_path() . '/id_image/department_color/FRONT/' . $employee['departments'][0]->color.'.png')){
        Fpdf::Image(url("/id_image/department_color/FRONT/") .'/'.  $employee['departments'][0]->color.'.png', 0, 0, 53.98, 85.60,'PNG');
    }

    if (file_exists( public_path() . '/id_image/company/' . $employee['companies'][0]->id.'.png')){
        Fpdf::Image(url("/id_image/company/") .'/'. $employee['companies'][0]->id.'.png', 0, 0, 53.98, 85.60,'PNG');
    }

    $fullname_font = 12;
    $fname_mname = utf8_decode($employee->first_name) .' '. $employee->middle_initial .'.';
    $fullname_height = Fpdf::GetMultiCellHeight(53.98, 5,  $fname_mname, 0);

    Fpdf::SetFont('Arial', 'B', $fullname_font);
    if($fullname_height <= 9){
        Fpdf::SetXY(0,50);
        Fpdf::MultiCell(53.98,5, $fname_mname ,0,'C');
        Fpdf::SetXY(0,55);
        Fpdf::MultiCell(53.98,5,utf8_decode($employee->last_name),0,'C');
    }
    else if($fullname_height >= 10 && $fullname_height <= 15){ 
        $fullname_font = $fullname_font - 2;
        Fpdf::SetFont('Arial', 'B', $fullname_font);
        Fpdf::SetXY(0,50);
        Fpdf::MultiCell(53.98,5,$fname_mname ,0,'C');
        Fpdf::SetXY(0,55);
        Fpdf::MultiCell(53.98,5,utf8_decode($employee->last_name),0,'C');
    }
    else{
        $fullname_font = $fullname_font - 7;
        Fpdf::SetFont('Arial', 'B', $fullname_font);
        Fpdf::SetXY(0,50);
        Fpdf::MultiCell(53.98,3,$fname_mname ,0,'C');
        $gety =  Fpdf::GetY();
        Fpdf::SetXY(0, $gety);
        Fpdf::MultiCell(53.98,3,utf8_decode($employee->last_name),0,'C');
    }

    Fpdf::SetFont('Arial', '', 7);
    Fpdf::SetXY(0, 60);
    Fpdf::MultiCell(53.98,4,"ID Number: " . $employee->employee_number ,0,'C');

    if (file_exists( public_path() . '/id_image/employee_signature/' . $employee->id.'.png')){

        $signature = public_path() . '/id_image/employee_signature/' . $employee->id . '.png';
        $destinationPath = public_path('/id_image/temp_employee_signature/');

        if(!File::isDirectory($destinationPath)){
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        $img = Image::make($signature);

        $img->resize(500, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'. $employee->id . '.png');

        if (file_exists( public_path() . '/id_image/temp_employee_signature/' . $employee->id.'.png')){
            Fpdf::Image(url("/id_image/temp_employee_signature/") . '/' . $employee->id.'.png', 17, 65, 22, 11,'PNG');
        }
    }

    Fpdf::SetFont('Arial', 'B', 10);
    Fpdf::SetXY(0,77);

    $department = $employee['departments'][0]->name;
    $count_string_department = strlen($department);
    if($count_string_department > 23){
        $height_department  = 4.5;
    }else{
        $height_department  = 8.5;
    }

    Fpdf::SetTextColor(255,255,255);
    Fpdf::MultiCell(53.98,$height_department,$department,0,'C');

    Fpdf::AddPage("P", [85.60, 53.98]);
    Fpdf::SetMargins(0,0,0,0);
    Fpdf::SetAutoPageBreak(false);

    if (file_exists( public_path() . '/id_image/department_color/BACK/' . $employee['departments'][0]->color.'.jpg')){
        Fpdf::Image(url("/id_image/department_color/BACK/") . '/' . $employee['departments'][0]->color.'.jpg', 0, 0, 53.98, 85.60);
    }

    Fpdf::SetTextColor(0,0,0);
    Fpdf::SetFont('Arial', '', 6);
           
    Fpdf::SetXY(15, 10);
    Fpdf::MultiCell(35,3,utf8_decode($employee->contact_person),0,'L');

    if(isset($employee->contact_number)){ 
        Fpdf::SetXY(15, 13);
        Fpdf::MultiCell(35,3, $employee->contact_number ,0,'L');
        // Fpdf::MultiCell(35,3,"(". substr($employee->contact_number, 0, 3) .") " .  substr($employee->contact_number, -10) ,0,'L');
    }

    Fpdf::SetXY(15, 23);
    $current_address_font = 6;
    if(isset($employee->current_address)){
        $current_address_height = Fpdf::GetMultiCellHeight(37, 2,  $employee->current_address, 0);

        if($current_address_height <= 2){
            Fpdf::MultiCell(37,2,$employee->current_address,0,'L');
        }
        else if($current_address_height > 2 && $current_address_height <= 6){ 
            Fpdf::MultiCell(37,2,$employee->current_address,0,'L');
        }
        else{
            $current_address_font = $current_address_font - 1;
            Fpdf::SetFont('Arial', '', $current_address_font);
            Fpdf::MultiCell(37,2,$employee->current_address,0,'L');
        }
    }
  

    if(isset($employee->sss_number)){
        Fpdf::SetXY(15, 34);
        Fpdf::MultiCell(10,2.5,"SSS",0,'L');
        Fpdf::SetXY(25, 34);
        Fpdf::MultiCell(25,2.5,": " . $employee->sss_number,0,'L');
    }

    if(isset($employee->tax_number)){
        Fpdf::SetXY(15, 36.5);
        Fpdf::MultiCell(10,2.5,"TIN",0,'L');

        Fpdf::SetXY(25, 36.5);
        Fpdf::MultiCell(25,2.5,": " . $employee->tax_number,0,'L');
    }

    if(isset($employee->phil_number)){
        Fpdf::SetXY(15, 39);
        Fpdf::MultiCell(10,2.5,"PHIC",0,'L');

        Fpdf::SetXY(25, 39);
        Fpdf::MultiCell(25,2.5,": " . $employee->phil_number,0,'L');
    }

    if(isset($employee->hdmf)){
        Fpdf::SetXY(15, 41.5);
        Fpdf::MultiCell(10,2.5,"HDMF",0,'L');
        Fpdf::SetXY(25, 41.5);
        Fpdf::MultiCell(25,2.5,": " . $employee->hdmf,0,'L');
    }
   

    Fpdf::SetTextColor(255,255,255);
    Fpdf::SetFont('Arial', '', 5);
    Fpdf::SetXY(0, 79);
    if(isset($address)){
        Fpdf::MultiCell(53.98,2.5,$address,0,'C');
    }
    Fpdf::Output(utf8_decode($employee->last_name) .'_' . utf8_decode($employee->first_name) . '_' . $employee->employee_number  . ".pdf", 'I');
    exit();
    
@endphp