<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
require_once '../core.php';
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
require_once("../fpdf/fpdf.php");
class PDF extends FPDF
{
        // Page header
        function Header()
        {
                // Logo
                $this->Image('../../img/logo.png',10,6,30);
                // Arial bold 15
                $this->SetFont('Arial','B',15);
                // Move to the right
                // $this->Cell(30);
                // Title
                $this->SetTextColor(220,50,50);
                $this->Cell(0,10,'Payment Receipt',0,1,'R');
                // Line break
                $this->Ln(18);

                //Drawing horizontal line
                $this->SetDrawColor(220,50,50);
                $this->Cell(1000,0,'',1,1,'R');
                $this->Ln(3);
                $this->SetFont('Arial','B',12);
                $this->SetTextColor(0,0,0); 
                $this->cell(0,2,"Cyber Flow",0,1,'L');
                $this->SetFont('Arial','',8);
                $this->cell(0,2,'Date : '.date("F j Y "),0,1,'R');
                $this->MultiCell(100,4,"LOHARU CHOWK, BHIWANI ROAD, CHARKHI DADRI,BHIWANI,HARYANA-127306",0,'L');

               
                //Drawing horizontal line
                $this->SetDrawColor(220,50,50);
                $this->Cell(1000,0,'',1,1,'R');
                $this->Ln(5);
                
                

        }

        // Colored table single cell table
        function FancyTable($header, $data,$shiftcells,$colwidths)
        {
                // Colors, line width and bold font
                $this->SetFillColor(255,0,0);
                $this->SetTextColor(255);
                $this->SetDrawColor(128,0,0);
                $this->SetLineWidth(.3);
                $this->SetFont('Times','B'); 
                $this->Cell($shiftcells);
                // Header
                $w = $colwidths;
                for($i=0;$i<count($header);$i++)
                        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
                $this->Ln();
                // Color and font restoration
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('Times');
                $this->Cell($shiftcells);
                // Data
                $fill = false;
                foreach($data as $row)
                {
                        $i=0;
                        foreach($row as $text)
                        {
                                $this->Cell($w[$i],6,$text,'LR',0,'L',$fill);
                                $i++;
                        } 
                        $this->Ln();
                        $fill = !$fill;
                }
                // Closing line
                $this->Cell($shiftcells);
                $this->Cell(array_sum($w),0,'','T');
                $this->Ln();
        }

        // Colored table multicell table
        function MultiFancyTable($header, $data,$shiftcells,$colwidths)
        {
                // Colors, line width and bold font
                $this->SetFillColor(255,0,0);
                $this->SetTextColor(255);
                $this->SetDrawColor(128,0,0);
                $this->SetLineWidth(.3);
                $this->SetFont('Times','B',10); 
                $this->Cell($shiftcells);
                // Header
                $w = $colwidths;
                for($i=0;$i<count($header);$i++)
                        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
                $this->Ln();
                // Color and font restoration
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('Times','',10);
                $this->Cell($shiftcells);
                // Data
                $fill = false;
                foreach($data as $row)
                {
                        $i=0;
                        foreach($row as $text)
                        {
                                $this->MultiCell($w[$i],1,$text,'LR','L',$fill);
                                $i++;
                        } 
                        $this->Ln();
                        $fill = !$fill;
                }
                // Closing line
                $this->Cell($shiftcells);
                $this->Cell(array_sum($w),0,'','T');
                $this->Ln();
        }

        // Page footer
        function Footer()
        {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial','I',8);
                // Page number
                $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

}
 
$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string. 

if($isValidChecksum == "TRUE") {  
	if (isset($_POST) && count($_POST)>0 )
	{ 
        $status = $_POST['STATUS'];
        $txnid = $_POST['TXNID'];
        $order_id = $_POST['ORDERID'];
        $txnAmt = $_POST['TXNAMOUNT'];
        $sql="update transactions set txn_id='$txnid',status='$status' where order_id='$order_id'";
        $conn->query($sql);
        $sql ="select amt,u_id,service_id from transactions where order_id='$order_id'";
        $result=$conn->query($sql);
        $TXN_DATA = $result->fetch_assoc();
        $USER_ID = $TXN_DATA['u_id'];
        $amt = $TXN_DATA['amt'];
        $COURSE_ID = $TXN_DATA['service_id'];   
        if($status=='TXN_SUCCESS' && $amt==$txnAmt)
        { 
                
             $sql ="INSERT INTO enrolled(u_id,course_id) values('$USER_ID','$COURSE_ID')";
             if($conn->query($sql)===true)
             {
                $sql="SELECT u.*,c.name as course_name,c.price,c.duration  FROM users u,courses c WHERE u.id=$USER_ID and c.id=$COURSE_ID";
                if($result=$conn->query($sql))
                {
                        if($result->num_rows)
                        {
                                $row = $result->fetch_assoc();
                                $user_name = ucfirst($row['name']);
                                $email = $row['email'];
                                $address = $row['address'];
                                $course_name = ucfirst($row['course_name']);
                                $duration = $row['duration'];
                                $price = number_format($row['price']);
                                // Instanciation of inherited class
                                $pdf = new PDF();
                                $pdf->AliasNbPages();
                                $pdf->AddPage();
                                $pdf->SetFont('Times','',10);
                                //payment deatils table
                                $header= array('Payment Mode','Payment Id');
                                $data=array(array("online","$order_id"));
                                $colwidths = array(30, 55);
                                $pdf->FancyTable($header, $data,110,$colwidths);
                                //line break
                                $pdf->Ln(5);
                                //bill to table
                                $header=array("Bill To");
                                $data = array(array("\n\n$user_name \n\n\n\n$email \n\n\n\n\n$address\n\n "));
                                $colwidths= array(85);
                                $pdf->MultiFancyTable($header, $data,110,$colwidths);
                                //line break
                                $pdf->Ln(20);
                                //description rable
                                $header = array("Description","Duration","Total Amount");
                                $data = array(array("$course_name","$duration months","Rs $price/-"));
                                $colwidths=array(100,50,40);
                                $pdf->FancyTable($header, $data,1,$colwidths);
                                //shifting cells
                                $pdf->Cell(80);
                                $pdf->Cell(0,10,"Total : Rs $price/-",0,0,'R');
                                
                                $pdf->Output("F","../../admin/invoices/$user_name$order_id.pdf");
                                $pdf->Output();
                                $sql="update transactions set invoice='$user_name$order_id.pdf' where order_id='$order_id'";
                                $conn->query($sql);
                        }
                }    
                
             }else
             {
                     echo $conn->error;
             }
           
        }
		
	}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>