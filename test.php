<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PointOfSales extends CI_Controller
{
	function __construct(){
			parent::__construct();
			$this->load->helper(array('html','url','form_helper'));
			$this->load->library(array('pagination','form_validation','x5codelib','x5codetime'));			
            $this->load->model(array('Fislogin','Fismenu','Fisaccess','Fisparam','Fisemployee','Fispos','x5code'));
			$this->load->library(array('session'));
			$this->userid= $this->session->userdata('userid');
            $this->username= $this->session->userdata('username');
			$this->userimg= $this->session->userdata('userimg');
            $this->useracc= $this->session->userdata('useracc');
            $this->appname = "PointOfSales";
			//$this->nama = $this->x5code->getNameByID($this->userid);
		}

	function Index($page="ProductList")
		{
			if( ! $this->Fislogin->terdaftar())
			{
				redirect('MainPage');                
			}
			else				                
			{	                
             
                $this->load->view('x5cpluginhead');			
                $header['name'] = $this->username;
                $header['acc'] = $this->useracc;
                $header['brand'] = 'FluffyPOS - PT Sarana Mega Fortuna';                
                $this->load->view('x5chead',$header);                                                
                
                if($this->Fisaccess->GetGroupAccess($this->useracc)!='PO')
                {
                    redirect('MainPage');
                }
                else
                {    
                    $nav['ListMenu'] = $this->Fismenu->AccessMenu($this->useracc);
                    $nav['Department']= 'Point Of Sales';
                    $nav['DepSmall']= 'POS';
                    $this->load->view('x5cnavigation',$nav);
                    $this->load->view('x5cbreadcrumb');
                    switch($page){
                        case 'Dashboard':
                            $this->load->view($page);
                            $this->load->view('x5cfoot');
                            $this->load->view('x5cpluginfoot');
                        break;
                        case 'ParameterJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fisparam->GetParamById($DataAccess);                       
                            header('Content-Type: application/json');
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'ProductJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListProduct();                       
                            header('Content-Type: application/json');
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'DiscountJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListDiscount();                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                         case 'StockJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListStockHeader();                       
                            header('Content-Type: application/json');
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'ListBarcode':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListBarcode();                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'SalesJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();       
                            $period1 =$this->input->get('period1');
                            $period2 =$this->input->get('period2');
                            $filter= $this->input->get('filter');
                            $value = $this->input->get('value');
                      
                            $parDetails = $this->Fispos->ListSales($period1,$period2,$filter,$value);                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'StocksJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();
                            $filter= $this->input->get('filter');
                            $value = $this->input->get('value');
                      
                            $parDetails = $this->Fispos->ListStock($filter,$value);                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'DataJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();       
                            $period1 =$this->input->get('period1');
                            $period2 =$this->input->get('period2');
                            $filter= $this->input->get('filter');
                            $value = $this->input->get('value');                         
                            $parDetails = $this->Fispos->ListMutasi($period1,$period2,$filter,$value);                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'ListUser':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListUser();                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'ListMstranTMP':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListMstranTMP();                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                         case 'ListMstranRetTMP':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListMstranRetTMP();                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'QueuingJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->ListQueuing();                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;
                        case 'TempSales':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            $parDetails = $this->Fispos->MySales();                       
                            header('Content-Type: application/json');
                            if($parDetails==null)
                            {
                                $parDetails='';
                            }
                            $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;                                
                        case 'ProductCodeJson':
                            $DataAccess = $this->input->get('param');  
                            $data = array();                               
                            //$this->Fispos->ListProductCode();                       
                            $parDetails = $this->Fispos->ListProductCode();
                            
                            foreach($parDetails as $par):
                                array_push($data,$par['PRDCD']);
                            endforeach;
                            
                            header('Content-Type: application/json');
                            $data = str_replace("}},{","},",$this->my_json_encode($data));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;   
                        case 'ProductByCodeJson':
                            //$DataAccess = $this->input->get('param');  
                            $DataAccess = 'BKS';
                            $data = array();                               
                            //$this->Fispos->ListProductCode();                       
                            $parDetails = $this->Fispos->ListProductByCode($DataAccess);
                            header('Content-Type: application/json');
                            $data = str_replace("}},{","},",$this->my_json_encode($parDetails));
                            //$data = str_replace("[","",$data);
                            //$data = str_replace("]","",$data);                        
                            exit($data);
                        break;                                                     
                        case 'ProductUpdate':
                            $EmplId = $this->input->get('EmployeeId');                                                        
                            $data['Status'] = $this->Fisparam->GetParamById('EmployeeStatus'); 
                            $data['Relationship'] = $this->Fisparam->GetParamById('EmployeeMarital');
                            $data['Payment'] = $this->Fisparam->GetParamById('PaymentMethod');
                            $data['Department'] = $this->Fisparam->GetParamById('Department');
                            $data['FunctionalGroup'] = $this->Fisparam->GetParamById('FunctionalGroup');                     
                            $data['Jabatan'] = $this->Fisparam->GetParamById('EmployeePosition');                            
                            $data['Employee'] = $this->Fisemployee->GetEmployee($EmplId); 
                            $data['Bank'] = $this->Fisparam->GetParamById('PaymentBank'); 
                            $data['ListFacility'] = $this->Fisemployee->ListConst();  
                            $data['length'] = $this->Fisparam->GetParamById('ContractLength'); 
                            $this->load->view('HRM/EmployeeUpd',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('x5cplugin');   
                        break;
                        case 'ProductList':
                            $data['Category'] = $this->Fisparam->GetParamById('Kategori'); 
                            $data['Color'] = $this->Fisparam->GetParamById('Color'); 
                            $data['Sizes'] = $this->Fisparam->GetParamById('Size'); 
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $this->load->view('POS/ProductList',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/ProductPlugins');    
                        break;
                        case 'Discount':
                            $data['Type'] = $this->Fisparam->GetParamById('DiscountType');
                            //$data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));                             
                            $this->load->view('POS/DiscountList',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/DiscountPlugins');    
                        break;
                        case 'BPB':
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $data['Refer'] = $this->Fisparam->GetParamById('Reference');  
                            $data['Docno'] = $this->Fispos->GetLastDocno('B');
                            $this->load->view('POS/BPBV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/BPBPlugins');    
                        break; 
                        case 'Retur':
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $data['Refer'] = $this->Fisparam->GetParamById('Reference');  
                            $data['Docno'] = $this->Fispos->GetLastDocno('R');
                            $this->load->view('POS/ReturProductV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/ReturProductPlugins');    
                        break;
                        case 'Stock':
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));
                            $DataAccess = 'sgs';                     
                            $data['List'] = $this->Fispos->ListProductByCode($DataAccess);
                            $this->load->view('POS/StockV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/StockPlugins');    
                        break;
                        case 'ReportBarcode':
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $data['Refer'] = $this->Fisparam->GetParamById('Reference');  
                            $this->load->view('POS/ReportBarcodeV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/ReportPlugins');    
                        break;  
                         case 'ReportProduct':    
                            $data['Retur'] = $this->Fispos->GroupBy('R');
                            $data['BPB'] = $this->Fispos->GroupBy('B');
                            $this->load->view('POS/ReportProductV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/ReportProductPlugins');    
                        break;
                        case 'UserManagement':
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $data['Refer'] = $this->Fisparam->GetParamById('Reference');  
                            $this->load->view('POS/UserV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/UserPlugins');    
                        break; 
                        case 'ReportSales':
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $data['Refer'] = $this->Fisparam->GetParamById('Reference');  
                            $data['Kategori'] = $this->Fisparam->GetParamById('Kategori');
                            $data['Code'] = $this->Fispos->GetProductByCode();
                            $data['Ukuran'] = $this->Fisparam->GetParamById('Size');
                            $data['Corak'] = $this->Fisparam->GetParamById('Color');
                            $this->load->view('POS/ReportSalesV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/ReportSalesPlugins');    
                        break; 
                            
                         case 'ReportLPM':
                            $data['Kategori'] = $this->Fisparam->GetParamById('Kategori');
                            $data['Code'] = $this->Fispos->GetProductByCode();
                            $data['Ukuran'] = $this->Fisparam->GetParamById('Size');
                            $data['Corak'] = $this->Fisparam->GetParamById('Color');
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $data['Refer'] = $this->Fisparam->GetParamById('Reference');  
                            $this->load->view('POS/ReportStockV',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('POS/ReportStockPlugins');    
                        break;   
                         case 'Parameter':
                            $data['ListAccess'] = $this->Fisaccess->ListAccess($this->Fisaccess->GetGroupAccess($this->useracc));    
                            $data['ListParam'] = $this->Fisparam->ListParam($this->Fisaccess->GetGroupAccess($this->useracc));  
                            $data['appname'] = $this->appname;
                            $this->load->view('x5cparam',$data);
                            $this->load->view('x5cfoot');
                            $this->load->view('x5cpluginparam');
                        break;
                    }                    
                    
                }
               
            }
		}
    
     function x5cDataId()
    {
        $param1 = $this->input->get('param1');  
        $param2 = $this->input->get('param2');
        $data = array();                               
        $parDetails = $this->Fispos->GetProductId($param1,$param2);                       
        header('Content-Type: application/json');
        $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
        //$data = str_replace("[","",$data);
        //$data = str_replace("]","",$data);

        exit(json_encode($parDetails));
    }
    
    function x5cDiscountId()
    {
        $param1 = $this->input->get('param1');  
        $param2 = $this->input->get('param2');
        $data = array();                               
        $parDetails = $this->Fispos->GetDiscountId($param1,$param2);                       
        header('Content-Type: application/json');
        $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
        //$data = str_replace("[","",$data);
        //$data = str_replace("]","",$data);

        exit(json_encode($parDetails));
    }
    function CetakBarcode()
    {        
        $data['ListBar'] = $this->Fispos->ListBarcode();
        //update image loc
        $datax = $this->Fispos->ListBarcode();
        if($datax):
        foreach($datax as $data2):
           $this->set_barcode($data2['PRDCD']);
        endforeach;
        endif;
        $this->load->view('POS/Barcode2',$data);
    }
    
    function CetakStruk($docno,$pay,$back,$totalpay)
    {      
         if( ! $this->Fislogin->terdaftar())
			{
				redirect('MainPage');                
			}
			else				                
			{
                $data['docno'] = $docno;
                $data['tot'] = $totalpay;
                $data['pay'] = $pay;
                $data['back'] = $back;        
                $data['ListTran'] = $this->Fispos->TransactionPrint($docno);
                $this->load->view('POS/TransactionPrint',$data);
            }
    }
                                    
    function StockDetails()
    {
        $DataAccess = $this->input->get('param1');  
        $data['Head'] = $this->Fispos->HeaderProductByCode($DataAccess);
        $data['List'] = $this->Fispos->ListProductByCode($DataAccess);
        $this->load->view('POS/StockDetails', $data);	        
    }
    function Transaction()
    {
        if( ! $this->Fislogin->terdaftar())
			{
				redirect('MainPage');                
			}
			else				                
			{	 
                $this->load->view('x5cpluginhead');	
                $header['name'] = $this->username;
                $header['acc'] = $this->useracc;
                $header['brand'] = 'FluffyPOS - PT Sarana Mega Fortuna';                
                //$this->load->view('x5chead',$header);   
                //$this->load->view('x5cnavigation',$nav);
                //$this->load->view('POS/TransactionHeader');
                $this->load->view('POS/Transaction',$header);
                $this->load->view('POS/TransactionPlugins');        
            }
    }
     function Sales()
    {
        if( ! $this->Fislogin->terdaftar())
			{
				redirect('MainPage');                
			}
			else				                
			{
                $this->load->view('x5cpluginhead');	
                $header['name'] = $this->username;
                $header['acc'] = $this->useracc;
                $header['brand'] = 'FluffyPOS - PT Sarana Mega Fortuna';                
                //$this->load->view('x5chead',$header);   
                //$this->load->view('x5cnavigation',$nav);
                //$this->load->view('POS/TransactionHeader');
                $this->load->view('POS/Seller',$header);
                $this->load->view('POS/SellerPlugins');     
            }
    }
  
    function x5cAdd($type)
    {   
        switch ($type) {
            case 'X5CUSER':
                    if($this->input->post('password')!=$this->input->post('confpassword'))
                    {
                         exit(json_encode(array('pesan' => 'Password tidak sama' , 'respond'=> 'failed')));	
                    }
                    if($this->Fispos->CheckUser($this->input->post('userid'),'x5cUser')==true)
                    {
                        exit(json_encode(array('pesan' => 'Username sudah ada' , 'respond'=> 'failed')));					
                    }
                    $data = array(                        
                        'UserId'=>$this->input->post('userid')
                        ,'UserPassword'=>md5($this->input->post('password'))
                        ,'Firstname'=>$this->input->post('firstname')
                        ,'Lastname'=>$this->input->post('lastname')						                     
                        ,'Email'=>$this->input->post('email')
                        ,'AccessType'=>$this->input->post('access')                                                             
                        ,'CreateBy'=>$this->userid
                        ,'CreateTime'=>date('Y-m-d H:i:s')
                    );
                 
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));	 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'POSDISCOUNT':                    
                  
                $act = $this->input->post('act');
                $prdcd= $this->input->post('prdcd'); 
                if($act=='1'):
                     if($this->Fispos->CheckActiveDiscount($this->input->post('type'),$this->input->post('prdcd'),$this->input->post('kondisi'))==true)
                    {
                        exit(json_encode(array('pesan' => 'Discount sudah ada' , 'respond'=> 'failed')));					
                    }
                    $data = array(                        
                        'PRDCD'=>$this->input->post('prdcd')
                        ,'DiscountType'=>$this->input->post('type')
                        ,'DiscountCondition'=>$this->input->post('kondisi')
                        ,'DiscountPercent'=>$this->input->post('percent')						                     
                        ,'PeriodStart'=>$this->input->post('period1')
                        ,'PeriodEnd'=>$this->input->post('period2')                                                             
                        ,'CreateBy'=>$this->userid
                        ,'CreateDate'=>date('Y-m-d H:i:s')
                    );
                 
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));	 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
                else:
                      
                         $data = array(                                              
                            'DiscountCondition'=>$this->input->post('kondisi')
                            ,'DiscountPercent'=>$this->input->post('percent')						                     
                            ,'PeriodStart'=>$this->input->post('period1')
                            ,'PeriodEnd'=>$this->input->post('period2')
                            ,'UpdateBy'=>$this->userid
                            ,'UpdateDate'=>date('Y-m-d H:i:s')
                        );
                        if($this->x5code->updateData($type,$this->input->post('id'),$data,'DiscountId')==true)
                        {			
                          
                            exit(json_encode(array('pesan' => 'Produk berhasil diubah' , 'respond'=> 'success')));					 
                        }
                        else
                        {
                            exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                        }
                endif;
                    
            break;
            case 'POSMTRANTMP':                 
                    $data = array(                        
                        'PRDCD'=>$this->input->post('prdcd')
                        ,'TRANDATE'=>date('Y-m-d H:i:s')
                        ,'DESC'=>$this->input->post('desk')
                        ,'QTY'=>$this->input->post('qty')						                     
                        ,'HPP'=>$this->input->post('hpp')
                        ,'PRICE'=>$this->input->post('price')                                       
                        ,'DISCOUNT'=>$this->input->post('discrp') 
                        ,'GROSS'=>$this->input->post('gross') 
                        ,'CREATEBY'=>$this->userid
                        ,'CREATEDATE'=>date('Y-m-d H:i:s')
                        ,'CASHIERNAME'=>$this->username
                    );
                    if($this->Fispos->CheckPrdcd($this->input->post('prdcd'),'posmtrantmp')==true)
                    {
                        //exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed2')));
                       
                        if($this->x5code->updateTran($this->input->post('prdcd'),$this->input->post('qty'),$this->input->post('discrp'),$this->input->post('gross'))==true)
                        {				
                            exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                        }
                        else
                        {
                            exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                        }
                    }
                
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            
            case 'POSPRODMAST':    
                    $act = $this->input->post('act');
                
                   
                    $code = $this->input->post('code');
                    $color= $this->input->post('color');
                    $size = $this->input->post('size');
                    $name = $this->input->post('name');
                    if($size==" ")
                    {
                        $prdcd = $code."-".$color;
                    }
                    else
                    {
                        $prdcd = $code."-".$size."-".$color;
                    }
                    $desc = $name." ".$color." ".$size;
                    
                    
                   
                    
                     if($act=='1'):
                        if($this->Fispos->CheckPrdcd($prdcd,'POSPRODMAST')==true)
                            {
                                exit(json_encode(array('pesan' => 'Produk sudah ada' , 'respond'=> 'failed')));					
                            }
                        $data = array(                        
                                'PRDCD'=>$prdcd
                                ,'CODE'=>$this->input->post('code')
                                ,'NAME'=>$this->input->post('name')
                                ,'DESC'=>$desc						                     
                                ,'KATEGORI'=>$this->input->post('category')
                                ,'PRICE'=>$this->input->post('price')                                       
                                ,'HPP'=>$this->input->post('hpp') 
                                ,'COLOR'=>$this->input->post('color') 
                                ,'SIZE'=>$this->input->post('size')                         
                                ,'CREATEBY'=>$this->userid
                                ,'CREATEDATE'=>date('Y-m-d H:i:s')
                             );
                        
                        if($this->x5code->addDB($type,$data)==true)
                        {				
                            $stmast = array(                        
                                'PRDCD'=>$prdcd
                             );
                            $this->x5code->addDB('POSSTMAST',$stmast);
                            exit(json_encode(array('pesan' => 'Produk berhasil ditambahkan' , 'respond'=> 'success')));					 
                        }
                        else
                        {
                            exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                        }
                    else:
                        if($this->Fispos->CheckPrdcd($prdcd,'POSPRODMAST')==true)
                            {
                                if($prdcd==$this->input->post('prdcd'))
                                {
                                    
                                }
                                else
                                {
                                    exit(json_encode(array('pesan' => 'Produk sudah ada' , 'respond'=> 'failed')));			
                                }
                            }
                        $data = array(
                        'PRDCD'=>$prdcd
                        ,'CODE'=>$this->input->post('code')
                        ,'NAME'=>$this->input->post('name')
                        ,'DESC'=>$desc						                     
                        ,'KATEGORI'=>$this->input->post('category')
                        ,'PRICE'=>$this->input->post('price')                                       
                        ,'HPP'=>$this->input->post('hpp') 
                        ,'COLOR'=>$this->input->post('color') 
                        ,'SIZE'=>$this->input->post('size')                         
                        ,'UPDATEBY'=>$this->userid
                        ,'UPDATEDATE'=>date('Y-m-d H:i:s')
                             );
                        if($this->x5code->updateData($type,$this->input->post('prdcd'),$data,'PRDCD')==true)
                        {			
                              $stmast = array(                        
                                'PRDCD'=>$prdcd
                             );
                            $this->x5code->updateData('POSSTMAST',$this->input->post('prdcd'),$stmast,'PRDCD');
                            $this->x5code->updateData('POSBARCODETMP',$this->input->post('prdcd'),$stmast,'PRDCD');
                            exit(json_encode(array('pesan' => 'Produk berhasil diubah' , 'respond'=> 'success')));					 
                        }
                        else
                        {
                            exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                        }
                    endif;
                
                
            break;
            case 'POSBARCODETMP':                 
                    $data = array(                        
                        'PRDCD'=>$this->input->post('prdcd') 
                        ,'DESC'=>$this->input->post('desc')
                        ,'SIZE'=>$this->input->post('size')
                        ,'COLOR'=>$this->input->post('color')
                        ,'QTY'=>$this->input->post('qty')
                    );
                    if($this->Fispos->CheckPrdcd($this->input->post('prdcd'),'posbarcodetmp')==true)
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed2')));					
                    }
                
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'POSMSTRANTMP':       
                    $date = date('Y-m-d H:i:s');
                    $data = array(                        
                        'DOCNO'=>$this->input->post('docno') 
                        ,'TRXDATE'=>$date
                        ,'PRDCD'=>$this->input->post('prdcd') 
                        ,'DESC'=>$this->input->post('desc')
                        ,'REMARK'=>$this->input->post('ket')
                        ,'QTY'=>$this->input->post('qty')
                        ,'PRICE'=>$this->input->post('price')
                        ,'GROSS'=>ceil($this->input->post('qty')*$this->input->post('price'))
                    );
                    if($this->Fispos->CheckPrdcd($this->input->post('prdcd'),'posmstrantmp')==true)
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed2')));					
                    }
                
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'POSMSTRANRETTMP':       
                    $date = date('Y-m-d H:i:s');
                    $data = array(                        
                        'DOCNO'=>$this->input->post('docno') 
                        ,'TRXDATE'=>$date
                        ,'PRDCD'=>$this->input->post('prdcd') 
                        ,'DESC'=>$this->input->post('desc')
                        ,'REMARK'=>$this->input->post('ket')
                        ,'QTY'=>$this->input->post('qty')
                        ,'PRICE'=>$this->input->post('price')
                        ,'GROSS'=>ceil($this->input->post('qty')*$this->input->post('price'))
                    );
                    if($this->Fispos->CheckPrdcd($this->input->post('prdcd'),'posmstranrettmp')==true)
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed2')));					
                    }
                
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'POSMSTRAN':       
                    $date = date('Y-m-d H:i:s');
                    $param1 = $this->input->get('param1');
                    $param2 = $this->input->get('param2');
                    $param3 = $this->input->get('param3');
                    if($this->Fispos->CheckDocno($param1,$param2)==true)
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed2')));					
                    }
                   
                    if($this->Fispos->addToMstran($param1,$param2,$param3)==true)
                    {				
                        $docno = $this->Fispos->GetLastDocno($param2);
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success','docno'=>$docno)));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'POSMTRAN':       
                    $date = date('Y-m-d H:i:s');
                    $param1 = $this->input->get('param1');
                    $param2 = $this->input->get('param2');
                    $param3 = $this->input->get('param3');
                   
                    if($this->Fispos->addToMtran('POSMTRANTMP')==true)
                    {		
                        $tran = $this->Fispos->Tranid();                    
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success','docno'=>$tran)));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'posmtranque':                      
                    if($this->Fispos->addQueuing($type,'PENDING')==true)
                    {			
                        $lastNoUrut = $this->Fispos->LastQue();
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success','nourut'=>$lastNoUrut)));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'ClearList':   
                      $param1 = $this->input->get('param1');
                    if($this->Fispos->ClearList($param1)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'updQTY':   
                    $prdcd = $this->input->get('param1');
                    $qty = $this->input->get('param2');
                    if($this->Fispos->updqty($prdcd,$qty,'posmtrantmp')==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'ClearRow':                  
                    $param1 = $this->input->get('param1');
                    $table = $this->input->get('param2');
                    $cond = 'PRDCD';
                    if($this->Fispos->ClearRow($table,$param1,$cond)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'ClearPRDCD':                  
                    $param1 = $this->input->get('param1');                                    
                    if($this->Fispos->updprdcd($param1)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'ClearRow3':                  
                    $param1 = $this->input->get('param1');
                    $table = $this->input->get('param2');
                    $cond = 'DiscountId';
                    if($this->Fispos->ClearRow($table,$param1,$cond)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'ClearRow2':                  
                    $param1 = $this->input->get('param1');
                    $table = $this->input->get('param2');
                    $cond = 'UserId';
                    if($this->Fispos->ClearRow($table,$param1,$cond)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));					 
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'CallSales':                  
                    $param1 = $this->input->get('param1');
                    if($this->Fispos->addSalesFromPending($param1)==true)
                        {				
                            exit(json_encode(array('pesan' => 'Selamat post successfully..' , 'respond'=> 'success')));	
                        }
                            else
                        {
                            exit(json_encode(array('pesan' => 'Post Failed..' , 'respond'=> 'failed2')));					
                        }
            break;
            case 'x5cParameter':  
                 if(empty($this->input->post('group')))
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed')));					
                    }        
                    $empl= $this->input->post('group');
                    $data = array(
                        'AccessGroup'=>substr($this->useracc,0,2)
                        ,'GroupCode'=>$this->input->post('group')
                        ,'ParamName'=>$this->input->post('param')
                        ,'Value'=>$this->input->post('value')						                     
                        ,'IsActive'=>$this->input->post('isactive')                                           
                    );                 
                    if($this->x5code->addDB($type,$data)==true)
                    {				            
                        exit(json_encode(array('pesan' => 'Save Successfully..' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Save Faileds..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'x5cConst':  
                if(empty($this->input->post('constid')) or empty($this->input->post('constname')))
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed')));					
                    }
                                
                    $data = array(
                        'ConstId'=>$this->input->post('constid')
                        ,'ConstName'=>$this->input->post('constname')	
                        ,'ConstType'=>$this->input->post('constype')
                        ,'ConstEmployeePercent'=>$this->input->post('pegawai')
                        ,'ConstCompanyPercent'=>$this->input->post('perusahaan')
                        ,'reference'=>$this->input->post('reference')
                        ,'formula'=>$this->input->post('formula')
                        ,'amount'=>$this->input->post('amount')
                    );
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Save Successfully..' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Save Faileds..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'x5cPosting':  
                 if(empty($this->input->post('postid')) || empty($this->input->post('year')) || empty($this->input->post('month'))|| empty($this->input->post('paydate')))
                    {
                        exit(json_encode(array('pesan' => 'Data belum lengkap' , 'respond'=> 'failed')));					
                    }       
                    $period = $this->input->post('year').$this->input->post('month');
                    if($this->Fisemployee->CheckPeriod($period)==false)
                    {
                        exit(json_encode(array('pesan' => 'Periode posting sudah ada' , 'respond'=> 'failed')));
                    }
                        
                    $data = array(
                        'PostId'=>$this->input->post('postid')
                        ,'PostPeriod'=>$this->input->post('year').$this->input->post('month')	
                        ,'PostPayDate'=>$this->input->post('paydate')
                        ,'PostDate'=>$this->input->post('postdate')
                        ,'PostBy'=>$this->input->post('poster')
                        ,'TableReference'=>$type.$this->input->post('postid')
                    );
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        $this->Fisemployee->GeneratePosting($this->input->post('postid'));
                        exit(json_encode(array('pesan' => 'Save Successfully..' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Save Faileds..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'x5cEmployeeDetails':  
                    if(empty($this->input->get('emplid')) or empty($this->input->get('constid')))
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed')));					
                    }
                    $constid = $this->input->get('constid');	
                    $emplid = $this->input->get('emplid');                 
                    
                    $arr = $this->Fisemployee->GetAmount($constid,$emplid);                 
                    $amount = $arr['employee'];
                    $amountCompany = $arr['company']; 
                
                    if($this->Fisemployee->CheckFacility($constid,$emplid)==false)
                    {
                        exit(json_encode(array('pesan' => 'Fasilitas sudah ada' , 'respond'=> 'failed')));	
                    }                
                    $data = array(
                        'EmployeeId'=>$this->input->get('emplid')
                        ,'Constid'=>$this->input->get('constid')				                     
                        ,'AccountId'=>$this->input->get('acctid')   
                        ,'PrincipalAmount'=>$amount
                        ,'PrincipalAmountCompany'=>$amountCompany
                        ,'IsActive'=>'Y'
                    );
                    if($this->x5code->addDB($type,$data)==true)
                    {				
                        exit(json_encode(array('pesan' => 'Save Successfully..' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'edit':
                $this->update('menu');
                break;
            case 'del':
                $this->delete('menu');
                break;
        }
    }
    function x5cEdit($type)
    {   
        switch ($type) {
            case 'Employee':
                $this->Create('menu');
                break;
                case 'x5cEmployee':  
                 if(empty($this->input->post('nik')))
                    {
                        exit(json_encode(array('pesan' => 'Update Failed..' , 'respond'=> 'failed')));					
                    }        
                    $empl= $this->input->post('nik');
                    $data = array(
                        'EmployeeName'=>$this->input->post('name')
                        ,'EmployeePosition'=>$this->input->post('position')
                        ,'Department'=>$this->input->post('department')						                     
                        ,'FunctionalGroup'=>$this->input->post('functional')
                        ,'EmployeeMarital'=>$this->input->post('relationship')
                        ,'EmployeeGender'=>$this->input->post('gender')
                        ,'EmployeePhoneNumber'=>$this->input->post('phone')
                        ,'EmployeePhoto'=>$this->input->post('photo')
                        ,'EmployeeAddress'=>$this->input->post('address')
                        ,'EmployeeCardId'=>$this->input->post('ktp')
                        ,'EmployeeStatus'=>$this->input->post('status')
                        ,'ContractLength'=>$this->input->post('length')
                        ,'EmployeeContract'=>$this->input->post('cadesc')
                        ,'EmployeeHireDate'=>$this->input->post('startdate')
                        ,'EmployeeQuitDate'=>$this->input->post('enddate')
                        ,'EmployeeMother'=>$this->input->post('mothername')
                        ,'PaymentMethod'=>$this->input->post('method')
                        ,'PaymentAccount'=>$this->input->post('account')
                        ,'PaymentBank'=>$this->input->post('bank')                        
                        ,'EmployeeSalary'=>$this->input->post('salary')                        
                    );                 
                    if($this->x5code->updateData($type,$empl,$data,'EmployeeId')==true)
                    {				            
                        exit(json_encode(array('pesan' => 'Update Successfully..' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Update Faileds..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'x5cParameter':  
                      
                    if(empty($this->input->post('group')))
                    {
                        exit(json_encode(array('pesan' => 'Update Failed..' , 'respond'=> 'failed')));					
                    }        
                    $empl= $this->input->post('group');
                    $val= $this->input->post('lastvalue');
                    $param = array(
                        'GroupCode'=>$empl
                        ,'Value'=>$val
                    );
                    $data = array(
                        'GroupCode'=>$this->input->post('group')
                        ,'ParamName'=>$this->input->post('param')
                        ,'Value'=>$this->input->post('value')						                     
                        ,'IsActive'=>$this->input->post('isactive')                                           
                    );                   
                    if($this->x5code->updateParam($type,$data,$param)==true)
                    {				            
                        exit(json_encode(array('pesan' => 'Update Successfully..' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Update Faileds..' , 'respond'=> 'failed')));					
                    }
            break;
                 
            case 'x5cPosting':  
                 if(empty($this->input->post('nik')))
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed')));					
                    }        
                    $PostId= $this->input->post('upostid');
                    $param = $this->input->post('nik') ;
                    $type=$type.$PostId;
                    $AbsenDay = $this->input->post('abstaint');
                    
                    $thp = $this->Fisemployee->THP($param);                    
                    
                    $CutData = ceil(($thp/25)*$AbsenDay);
                    $data = array(
                        'Overtime'=>$this->input->post('overtime')
                        ,'OvertimePay'=>$this->input->post('overtimepay')	
                        ,'Backpay'=>$this->input->post('backpay')
                        ,'Abstaint'=>$this->input->post('abstaint')
                        ,'AbstaintPay'=> $CutData 
                    );                   
                    if($this->x5code->updateData($type,$param,$data,'EmployeeId')==true)
                    {				            
                        exit(json_encode(array('pesan' => 'Save Successfully..' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Save Faileds..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'x5cPostingFinish':  
                 if(empty($this->input->get('postid')))
                    {
                        exit(json_encode(array('pesan' => 'Save Failed..' , 'respond'=> 'failed')));					
                    }        
                    $PostId= $this->input->get('postid');                
                    $type='x5cPosting';                    
                    if($this->Fisemployee->FinishPosting($type,$PostId)==true)
                    {				            
                        exit(json_encode(array('pesan' => 'Posting Successfully' , 'respond'=> 'success')));								
                    }
                    else
                    {
                        exit(json_encode(array('pesan' => 'Posting Failed..' , 'respond'=> 'failed')));					
                    }
            break;
            case 'del':
                $this->delete('menu');
                break;
        }
    }
    function x5cDrop($param)
    {   
        switch ($param) {
            case 'Employee':
                $this->Create('menu');
                break;
            case 'edit':
                $this->update('menu');
                break;
            case 'del':
                $this->delete('menu');
                break;
        }
    }
    
    function x5cGetProductId()
    {
        $param1 = $this->input->get('param1');
        $data = array();                               
        $parDetails = $this->Fispos->GetProductId($param1);                       
        header('Content-Type: application/json');
        $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
        //$data = str_replace("[","",$data);
        //$data = str_replace("]","",$data);

        exit(json_encode($parDetails));
    }
    
    function x5cGetGrossDiscount()
    {
        $param1 = $this->input->get('param1');
        $data = array();                               
        $parDetails = $this->Fispos->GetDiscount();                       
        header('Content-Type: application/json');
         if($parDetails==null)
            {
                $parDetails='0';
            }
        $data = str_replace("}},{","},",$this->my_json_encode(array('data'=>$parDetails)));
        //$data = str_replace("[","",$data);
        //$data = str_replace("]","",$data);
        exit(json_encode($parDetails));
    }
    
    function my_json_encode($in) { 
          $_escape = function ($str) { 
            return addcslashes($str, "\v\t\n\r\f\"\\/"); 
          }; 
          $out = ""; 
          if (is_object($in)) { 
            $class_vars = get_object_vars(($in)); 
            $arr = array(); 
            foreach ($class_vars as $key => $val) { 
              $arr[$key] = "\"{$_escape($key)}\":\"{$val}\""; 
            } 
            $val = implode(',', $arr); 
            $out .= "{{$val}}"; 
          }elseif (is_array($in)) { 
            $obj = false; 
            $arr = array(); 
            foreach($in AS $key => $val) { 
              if(!is_numeric($key)) { 
                $obj = true; 
              } 
              $arr[$key] = $this->my_json_encode($val); 
            } 
            if($obj) { 
              foreach($arr AS $key => $val) { 
                $arr[$key] = "\"{$_escape($key)}\":{$val}"; 
              } 
              $val = implode(',', $arr); 
              $out .= "{{$val}}"; 
            }else { 
              $val = implode(',', $arr); 
              $out .= "[{$val}]"; 
            } 
          }elseif (is_bool($in)) { 
            $out .= $in ? 'true' : 'false'; 
          }elseif (is_null($in)) { 
            $out .= 'null'; 
          }elseif (is_string($in)) { 
            $out .= "\"{$_escape($in)}\""; 
          }else { 
            $out .= $in; 
          } 
          return "{$out}"; 
        } 

    
        private function set_barcode($code)
        {
            //load library
            
            // header("Content-type: image/png");
            $this->load->library('zend');
            //load in folder Zend
            $this->zend->load('Zend/Barcode');
           
           $this->zend->load('Zend/Barcode');
           $file = Zend_Barcode::draw('code128', 'image', array('text' => $code,'barThickWidth'=>3,'barHeight'=>50,'withChecksum'=>true,'font'=>'3','fontSize'=>'12','drawText'=>false), array());  
           $store_image = imagepng($file,"assets/barcode/{$code}.png");
        
           return "assets/barcode/{$code}.png";

            
        }
    
	
}		