<?Php

class Fispos extends CI_MODEL
		{
			var $CI = NULL;
			function __construct(){
				parent::__construct();
				$this->load->database();
				$this->load->library(array('session'));
				$this->userid = $this->session->userdata('userid');
                $this->username = $this->session->userdata('username');

		}

        function ListProduct()
			{					
                $que2 = $this->db->query("select prod.*,par.ParamName as KategoriName,C.ParamName as ColorName,d.ParamName as SizeName from POSProdmast prod left join x5cParameter par on par.GroupCode='Kategori' and prod.Kategori=par.Value left join x5cParameter c on c.GroupCode='Color' and prod.Color=c.Value left join x5cParameter d on d.GroupCode='Size' and prod.Color=d.Value");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        function ListSales($prd1,$prd2,$filter,$value)
			{			
               
                switch($filter)
                {
                    case 'corak':
                        $str = "where a.COLOR='$value'";
                    break;
                    case 'ukuran':
                        $str = "where a.SIZE='$value'";
                    break;
                    case 'kategori':
                         $str = "where a.KATEGORI='$value'";
                    break;
                    case 'kode':
                         $value = str_replace(",","','",$value);
                         $str = "where a.CODE in ('$value')";
                    break;
                    case 'all':
                        $str = "";
                    break;
                }
                
              
                if($str!="")
                {
                    $prd = "AND DATE(TRANDATE)>='$prd1' AND DATE(TRANDATE)='$prd2'";
                }  
                else
                {
                    $prd = "WHERE DATE(TRANDATE)>='$prd1' AND DATE(TRANDATE)<='$prd2'";
                }
                
                $que2 = $this->db->query("select e.*,a.CODE,(e.GROSS-(e.HPP*e.QTY)) as MARGIN,b.ParamName as KategoriName,c.ParamName as SizeName,d.ParamName as ColorName from posprodmast a join x5cParameter b on b.GroupCode='Kategori' and a.KATEGORI=b.Value join x5cParameter c on c.GroupCode='Size' and a.SIZE=c.Value left join x5cParameter d on d.GroupCode='Color' and a.COLOR=d.Value join posmtran e on a.PRDCD=e.PRDCD $str $prd");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }
                
            }
            
            function ListStock($filter,$value)
			{
                switch($filter)
                {
                    case 'corak':
                        $str = "where a.COLOR='$value'";
                    break;
                    case 'ukuran':
                        $str = "where a.SIZE='$value'";
                    break;
                    case 'kategori':
                         $str = "where a.KATEGORI='$value'";
                    break;
                    case 'kode':
                         $value = str_replace(",","','",$value);
                         $str = "where a.CODE in ('$value')";
                    break;
                    case 'all':
                        $str = "";
                    break;
                }   
                $que2 = $this->db->query("select e.*,a.CODE,a.DESC,e.qty AS QTY,b.ParamName as KategoriName,c.ParamName as SizeName,d.ParamName as ColorName from posprodmast a join x5cParameter b on b.GroupCode='Kategori' and a.KATEGORI=b.Value join x5cParameter c on c.GroupCode='Size' and a.SIZE=c.Value left join x5cParameter d on d.GroupCode='Color' and a.COLOR=d.Value join posstmast e on a.PRDCD=e.PRDCD $str");
                
                //return "select e.*,a.CODE,e.qty AS QTY,b.ParamName as KategoriName,c.ParamName as SizeName,d.ParamName as ColorName from posprodmast a join x5cParameter b on b.GroupCode='Kategori' and a.KATEGORI=b.Value join x5cParameter c on c.GroupCode='Size' and a.SIZE=c.Value left join x5cParameter d on d.GroupCode='Color' and a.COLOR=d.Value join posstmast e on a.PRDCD=e.PRDCD $str";
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
            function ListMutasi($prd1,$prd2,$filter,$value)
			{			
            
                switch($filter)
                {
                    case 'bpb':
                        $str = "where B.TYPE='B'";
                    break;
                    case 'ret':
                        $str = "where B.TYPE='R'";
                    break;                  
                    case 'all':
                        $str = "";
                    break;
                }
                
                 if(strlen($value)>5)
                    {
                        $value = str_replace(",","','",$value);                            
                    }
                if($value!="")
                {
                    if($str!="")
                    {
                        $str = $str." AND B.DOCNO IN ('$value')";
                    }   
                }
                
                 if($str!="")
                {
                    $prd = "AND DATE(TRXDATE)>='$prd1' AND DATE(TRXDATE)<='$prd2'";
                }  
                else
                {
                    $prd = "WHERE DATE(TRXDATE)>='$prd1' AND DATE(TRXDATE)<='$prd2'";
                }
                //return "SELECT * FROM POSPRODMAST A JOIN POSMSTRAN B ON A.PRDCD=B.PRDCD $str $prd";
                $que2 = $this->db->query("SELECT * FROM POSPRODMAST A JOIN POSMSTRAN B ON A.PRDCD=B.PRDCD $str $prd");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
         function ListDiscount()
			{					
                $que2 = $this->db->query("SELECT * FROM POSDISCOUNT");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
      
        function GroupBy($type)
			{					
                $que2 = $this->db->query("SELECT * FROM POSMSTRAN where TYPE='$type' group by DOCNO");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        function ListMstranTMP()
			{					
                $que2 = $this->db->query("SELECT * FROM POSMSTRANTMP");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        function ListMstranRetTMP()
			{					
                $que2 = $this->db->query("SELECT * FROM POSMSTRANRETTMP");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        function StockByColor($prdcd,$size,$color)
        {                                 
            $que = $this->db->query("select QTY as ls from POSPRODMAST a left join POSSTMAST b on a.PRDCD=b.PRDCD where a.SIZE='$size' and a.COLOR='$color' and a.CODE='$prdcd'");							         
            $obj=0;
            foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];
				}			
				return $obj; 
              
                     
        }
        
        function CheckForDisc($gross)
        {                                 
            $que = $this->db->query("select * from x5cParameter where GrpCode='Discount'");	
            $row = $que->num_rows();
            
            foreach ($que->result_array() as $row)
				{
					$obj =  $row['Value'];
				}			
				return $obj; 
              
                     
        }
         function ListStockHeader()
			{					
                $que2 = $this->db->query("select prod.*,par.ParamName as KategoriName,C.ParamName as ColorName,d.ParamName as SizeName ,SUM(st.QTY) AS QTY from POSProdmast prod left join x5cParameter par on par.GroupCode='Kategori' and prod.Kategori=par.Value left join x5cParameter c on c.GroupCode='Color' and prod.Color=c.Value left join x5cParameter d on d.GroupCode='Size' and prod.Color=d.Value left join POSSTMAST st on prod.PRDCD=st.PRDCD group by prod.CODE");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
            
        function ListBarcode()
			{					
                $que2 = $this->db->query("select prod.*,C.ParamName as ColorName,d.ParamName as SizeName,e.QTY from POSProdmast prod left join x5cParameter c on c.GroupCode='Color' and prod.Color=c.Value left join x5cParameter d on d.GroupCode='Size' and prod.Color=d.Value join POSBARCODETMP e on prod.PRDCD=e.PRDCD");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
         function ListUser()
			{					
                $que2 = $this->db->query("SELECT a.*,b.ParamName as AccessType FROM x5cUser a left join x5cParameter b on a.AccessType=b.Value and b.GroupCode='AccessType' WHERE a.AccessType in('POA','POS','POC')");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
          function CheckDocno($param1,$param2)
			{					
                $query = $this->db->query("select * from posmstran where DOCNO='$param1' and TYPE='$param2'");
                if($query->num_rows()==1)
                    {
                        return true;					
                    }
                        else
                    {
                        return false;
                    }
            }
        
        function CheckPrdcd($param1,$table)
			{					
                $query = $this->db->query("select * from $table where PRDCD='$param1'");
                if($query->num_rows()==1)
                    {
                        return true;					
                    }
                        else
                    {
                        return false;
                    }
            }
         function CheckActiveDiscount($type,$prdcd,$cond)
			{					
                if($type=='POT')
                {                
                    $query = $this->db->query("select * from POSDISCOUNT where PRDCD='$prdcd'");
                }
                else
                {
                    $query = $this->db->query("select * from POSDISCOUNT where DiscountType='$type' and DiscountCondition='$cond'");
                }
                if($query->num_rows()==1)
                    {
                        return true;					
                    }
                        else
                    {
                        return false;
                    }
            }
         function CheckUser($param1,$table)
			{					
                $query = $this->db->query("select * from $table where UserId='$param1'");
                if($query->num_rows()==1)
                    {
                        return true;					
                    }
                        else
                    {
                        return false;
                    }
            }
        function MySales()
			{					
                $que2 = $this->db->query("select * from posmtrantmp where CreateBy='$this->userid'");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        function ListProductCode()
			{					
                $que2 = $this->db->query("select prod.PRDCD,prod.NAME from POSProdmast prod left join x5cParameter par on par.GroupCode='Kategori' and prod.Kategori=par.Value left join x5cParameter c on c.GroupCode='Color' and prod.Color=c.Value left join x5cParameter d on d.GroupCode='Size' and prod.Color=d.Value");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        function HeaderProductByCode($code)
			{					
                $que2 = $this->db->query("select prod.PRDCD,prod.NAME,prod.CODE,prod.SIZE,prod.COLOR,SUM(e.QTY) as QTY from POSProdmast prod left join x5cParameter par on par.GroupCode='Kategori' and prod.Kategori=par.Value left join x5cParameter c on c.GroupCode='Color' and prod.Color=c.Value left join x5cParameter d on d.GroupCode='Size' and prod.Color=d.Value left join POSSTMAST e on prod.PRDCD=e.PRDCD where CODE='$code' group by CODE");
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
         function GetProductByCode()
			{					
                $que2 = $this->db->query("select CODE as Value,CODE as ParamName from posprodmast group by CODE");
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
         function ListProductByCode($code)
			{					
                $que2 = $this->db->query("select prod.PRDCD,prod.NAME,prod.CODE,prod.SIZE,prod.COLOR from POSProdmast prod left join x5cParameter par on par.GroupCode='Kategori' and prod.Kategori=par.Value left join x5cParameter c on c.GroupCode='Color' and prod.Color=c.Value left join x5cParameter d on d.GroupCode='Size' and prod.Color=d.Value where CODE='$code' group by SIZE;");
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
         function HeaderDetails($nik,$period)
			{			
                $table = $this->GetPostingByPeriod($period);
                $que2 = $this->db->query("select a.*,b.ParamName as DepartmentName,c.ParamName as FunctionalGroupName,d.ParamName as StatusName from x5cEmployee a join x5cParameter b on b.GroupCode='Department' and a.Department=b.Value join x5cParameter c on c.GroupCode='FunctionalGroup' and a.FunctionalGroup=c.Value left join  x5cParameter d on d.GroupCode='EmployeeStatus' and a.EmployeeStatus=d.Value join $table e on a.EmployeeId=e.EmployeeId where a.EmployeeId in($nik)");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        
            
         function EmployeeDetails($period,$filter,$value)
			{			
               
                
                switch($filter)
                {
                    case 'Department':
                        $str = "where a.Department='$value'";
                    break;
                    case 'FunctionalGroup':
                        $str = "where a.FunctionalGroup='$value'";
                    break;
                    case 'PaymentMethod':
                         $str = "where a.PaymentMethod='$value'";
                    break;
                    case 'all':
                        $str = "";
                    break;
                }
                $table = $this->GetPostingByPeriod($period);
                $que2 = $this->db->query("select a.*,b.ParamName as DepartmentName,c.ParamName as FunctionalGroupName,a.PaymentMethod,d.ParamName as StatusName from x5cEmployee a join x5cParameter b on b.GroupCode='Department' and a.Department=b.Value join x5cParameter c on c.GroupCode='FunctionalGroup' and a.FunctionalGroup=c.Value left join x5cParameter d on d.GroupCode='EmployeeStatus' and a.EmployeeStatus=d.Value join $table e on a.EmployeeId=e.EmployeeId $str");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        function ListConst()
			{					
                $que2 = $this->db->query("select *,if(ConstType='Formula',formula,if(ConstType='Value',amount,if(ConstType='Percentage',reference,''))) as `Values` from x5cConst;");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        
        function ListPost($param)
			{				
                $table = "x5cPosting".$param;             
                $que2 = $this->db->query("select a.EmployeeId, a.EmployeeName, b.ParamName as Department, c.ParamName as FunctionalGroup, a.EmployeeSalary,a.Overtime,a.OvertimePay,a.BackPay,a.Abstaint,a.AbstaintPay from $table a left join x5cParameter b on b.GroupCode='Department' and a.Department=b.Value left join x5cParameter c on c.GroupCode='FunctionalGroup' and a.FunctionalGroup=c.Value");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            } 
        
        function ListPostId($param1,$param2)
			{				
                $table = "x5cPosting".$param2;             
                $que2 = $this->db->query("select * from $table where EmployeeId='$param1'");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            } 
        function ListQueuing()
			{				
                $date = date('Y-m-d');        
                $que2 = $this->db->query("select * from posque where date(SEQDATE)='$date' and FLAG='N'");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            } 
            
        function ListFacility($param)
			{					
                $que2 = $this->db->query("select * from x5cEmployeeDetails a left join x5cConst b on a.ConstId=b.ConstId where a.EmployeeId='$param' and a.IsActive='Y'");				
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        
        function addQueuing($table,$remark)
        {
          
          $id = $this->getLastQue();
          $que2 = $this->db->query("select * from posmtrantmp where CreateBy='$this->userid'");				
            if($que2->num_rows()<1)
                {
                    return false;
                }
                
          if($this->db->query("insert into posmtranque(TRANID, TRANDATE, PRDCD, `DESC`, QTY, HPP, PRICE, DISCOUNT, GROSS,CREATEBY,CREATEDATE) select '$id', TRANDATE,PRDCD,`DESC`,QTY,HPP,PRICE,DISCOUNT,GROSS,CREATEBY,CREATEDATE from posmtrantmp where CreateBy='$this->userid'"))
                    {                                               
                        $data = array(                        
                            'SEQID'=>$id                                                      
                            ,'SEQDATE'=>date('Y-m-d H:i:s')
                            ,'REMARK'=>$remark
                            ,'SELLERID'=>$this->userid
                            ,'SELLERNAME'=>$this->username
                            ,'FLAG'=>'N'
                        );
                        if($this->db->insert('posque',$data))			
                        {
                            $this->db->query("delete from posmtrantmp where CreateBy='$this->userid'");
                            return true;
                        }else{
                            $this->db->query("insert into posmtrantmp select * from posmtranque");
                            return false;				
                        }
                        return true;
                    }
                        else
                    {
                        return false;
                    }                   
            
        }
        function addToMstran($param1,$param2,$table)
        {
          $date = date('Y-m-d');              
          if($this->db->query("insert into posmstran(DOCNO, TRXDATE, PRDCD, `DESC`, QTY, PRICE, GROSS, REMARK, TYPE) select  DOCNO, TRXDATE, PRDCD, `DESC`, QTY, PRICE, GROSS, REMARK, '$param2' from $table where DOCNO='$param1'"))
                    {        
                        if($param2=='B')
                        {
                            $this->db->query("UPDATE POSSTMAST A,POSMSTRAN B SET A.QTY=A.QTY+B.QTY WHERE A.PRDCD=B.PRDCD and B.DOCNO='$param1'");  
                        }
                        else
                        {
                            $this->db->query("UPDATE POSSTMAST A,POSMSTRAN B SET A.QTY=A.QTY-B.QTY WHERE A.PRDCD=B.PRDCD and B.DOCNO='$param1'");                      
                        }
                        $this->db->query("delete from $table");
                        return true;
                    }
                        else
                    {
                        return false;
                    }
                               
            
        }
            
        function addToMtran($table)
        {
          $date = date('Y-m-d');        
          $docno = $this->GetLastTransaction();
          if($this->db->query("insert into posmtran(TRANID, TRANDATE, PRDCD, `DESC`, QTY, HPP, PRICE, DISCOUNT, GROSS, CREATEBY, CREATEDATE, UPDATEBY, UPDATEDATE, CASHIERNAME) select  '$docno', TRANDATE, PRDCD, `DESC`, QTY, HPP, PRICE, DISCOUNT, GROSS, CREATEBY, CREATEDATE, UPDATEBY, UPDATEDATE, CASHIERNAME from $table"))
                    {          
                        //update stock
                        $this->db->query("UPDATE POSSTMAST A,POSMTRAN B SET A.QTY=A.QTY-B.QTY WHERE A.PRDCD=B.PRDCD and B.TRANID='$docno'");                        
                        //delete tmp table
                        $this->db->query("delete from $table");
                        return true;
                    }
                        else
                    {
                        return false;
                    }
                               
            
        }
            
        function addSalesFromPending($tranid)
        {
          $date = date('Y-m-d');    
          $que2 = $this->db->query("select * from posmtrantmp");				
            if($que2->num_rows()>0)
                {
                    return false;
                }            
          if($this->db->query("insert into posmtrantmp(TRANDATE, PRDCD, `DESC`, QTY, HPP, PRICE, DISCOUNT, GROSS,CREATEBY,CREATEDATE) select  TRANDATE,PRDCD,`DESC`,QTY,HPP,PRICE,DISCOUNT,GROSS,'$this->userid',CREATEDATE from posmtranque where TRANID='$tranid' and date(TRANDATE)='$date'"))
                    {                                               
                        $data = array(                    
                            'FLAG'=>'Y'
                        );
                        $this->db->where('SEQID',$tranid);
                        if($this->db->update('posque',$data))			
                        {               
                            //$this->db->query("delete from posmtranque where tranid='$tranid'");
                            return true;
                        }else{                         
                            return false;				
                        }
                        return true;
                    }
                        else
                    {
                        return false;
                    }
                               
            
        }
        function ClearList($table)
        {
          
          $id = $this->getLastQue();
            if($table=='posbarcodetmp'){
                    $cond = "";
                }
            else
            {
                $cond = "WHERE CREATEBY='".$this->userid."'";
            }
          $que2 = $this->db->query("select * from $table $cond");				
                
                if($que2->num_rows()<1)
                    {
                        return false;
                    }
          if($this->db->query("DELETE FROM $table $cond"))
                    {               
                        return true;
                    }
                        else
                    {
                        return false;
                    }
        }
            
        function ClearRow($table,$param,$condition)
        {
                              
          if($this->db->query("DELETE FROM $table where $condition='$param'"))
                    {               
                        return true;
                    }
                        else
                    {
                        return false;
                    }
        }
            
        function updqty($prdcd,$qty,$table)
        {
                              
          if($this->db->query("update $table set QTY='$qty',GROSS=QTY*PRICE where PRDCD='$prdcd'"))
                    {               
                        return true;
                    }
                        else
                    {
                        return false;
                    }
        }
        
        function updprdcd($prdcd)
        {                              
          if($this->db->query("delete from posprodmast where PRDCD='$prdcd'"))
                    {               
                        $this->db->query("delete from posstmast where PRDCD='$prdcd'");
                        return true;
                    }
                        else
                    {
                        return false;
                    }
        }
            
        function GetEmployee($param)
			{					
                $que2 = $this->db->query("select a.*,b.ParamName as DepartmentName,c.ParamName as FunctionalGroupName,d.ParamName as StatusName,e.ParamName as ContractLengthName from x5cEmployee a join x5cParameter b on b.GroupCode='Department' and a.Department=b.Value join x5cParameter c on c.GroupCode='FunctionalGroup' and a.FunctionalGroup=c.Value left join  x5cParameter d on d.GroupCode='EmployeeStatus' and a.EmployeeStatus=d.Value left join x5cParameter e on e.GroupCode='ContractLength' and a.ContractLength=e.Value where a.EmployeeId='$param'");			
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        
        function GetProductId($param)
			{					
                $date = date('Ymd');
                $que2 = $this->db->query("select a.*,b.DiscountPercent from posprodmast a left join posdiscount b on a.PRDCD=b.PRDCD and (b.PeriodStart<='$date' and b.PeriodEnd>='$date') where a.PRDCD='$param'");			
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
            
         function GetDiscountId($param)
			{					
                $que2 = $this->db->query("select * from posdiscount where DiscountId='$param'");			
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
            
        function GetDataParamById($param1,$param2)
			{					
                $que2 = $this->db->query("select GroupCode,ParamName,Value,IsActive from x5cParameter where GroupCode='$param2' and Value='$param1'");			
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        
         function TransactionPrint($param1)
			{					
                $que2 = $this->db->query("select * from POSMTRAN WHERE TRANID='$param1'");			
                if($que2->num_rows()>0)
                    {
                        return $que2->result_array();
                    }                
            }
        
        function GetAmount($param1,$param2)
			{		
                
                $ConstType = $this->GetConstType($param1);                            
                switch($ConstType)
                {
                    case 'Value':
                         $que = $this->db->query("select amount as ls,amount as co from x5cConst where ConstId='$param1'");		
                    break;
                    case 'Formula':
                         $formula = $this->GetFormula($param1);
                         $que = $this->db->query($formula);		
                    break;
                    case 'Percentage':
                         $amount = $this->GetObject($param1,$param2);                    
                         $que = $this->db->query("select ((ConstEmployeePercent/100)*$amount) as ls,((ConstCompanyPercent/100)*$amount) as co from x5cConst where ConstId='$param1'");                           
                    break;
                }					
				foreach ($que->result_array() as $row)
				{
					$obj =  array("employee"=>$row['ls'],"company"=>$row['co']);
				}	
                
				return $obj;     
            }
            
        function GetLastQue()
			{	
                $date = date('Y-m-d');
				$que = $this->db->query("select max(substr(SEQID,1,4)) as ls from posque where date(SEQDATE)='$date'");				
				foreach ($que->result_array() as $row)
				{
					$id =  $row['ls']+1;
				}			
					$pjg = strlen($id);
                if($pjg==4)
				{
					$last = "".$id;
				}
				if($pjg==3)
				{
					$last = "0".$id;
				}
				if($pjg==2)
				{
					$last = "00".$id;
				}
				if($pjg==1)
				{
					$last = "000".$id;
				}
		
				return $last;
			}
        
        function GetLastDocno($type)
			{	
                $date = date('Y-m-d');
				$que = $this->db->query("select max(substr(DOCNO,1,4)) as ls from posmstran where `TYPE`='$type'");				
				foreach ($que->result_array() as $row)
				{
					$id =  $row['ls']+1;
				}			
					$pjg = strlen($id);
                if($pjg==4)
				{
					$last = "".$id;
				}
				if($pjg==3)
				{
					$last = "0".$id;
				}
				if($pjg==2)
				{
					$last = "00".$id;
				}
				if($pjg==1)
				{
					$last = "000".$id;
				}
		
				return $last;
			}
            
        function GetLastTransaction()
			{	
                $date = date('Y-m-d');
				$que = $this->db->query("select max(substr(TRANID,1,6)) as ls from posmtran");				
				foreach ($que->result_array() as $row)
				{
					$id =  $row['ls']+1;
				}			
					$pjg = strlen($id);
                if($pjg==6)
				{
					$last = "".$id;
				}
				if($pjg==5)
				{
					$last = "0".$id;
				}
                if($pjg==4)
				{
					$last = "00".$id;
				}
				if($pjg==3)
				{
					$last = "000".$id;
				}
				if($pjg==2)
				{
					$last = "0000".$id;
				}
				if($pjg==1)
				{
					$last = "00000".$id;
				}
		
				return $last;
			}
            
            
         function Tranid()
			{	
                $date = date('Y-m-d');
				$que = $this->db->query("select max(substr(TRANID,1,6)) as ls from posmtran");				
				foreach ($que->result_array() as $row)
				{
					$id =  $row['ls'];
				}			
				return $id;
			}
            
         function LastQue()
			{	
                $date = date('Y-m-d');
				$que = $this->db->query("select max(substr(TRANID,1,6)) as ls from posmtranque where CREATEBY='$this->userid' and DATE(TRANDATE)='$date'");				
				foreach ($que->result_array() as $row)
				{
					$id =  $row['ls'];
				}			
				return $id;
			}
            
            
            
        
        
            
        function GetObject($param1,$param2)
			{	
                $refer = $this->GetReference($param1);
                $pieces = explode(".", $refer);
                $table = $pieces[0]; 
                $column = $pieces[1];
                $where = $pieces[2];
                $value = $pieces[3];  
                if($value=="0")
                {
                    $value=$param2;
                }
                $que = $this->db->query("select $column as ls from $table where $where='$value'");               							
				foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];
				}			
				return $obj;
			}
        
        function GetDiscount()
			{    
                $total = $this->TotalWithoutDisc();
                if($total=="")
                {
                    $total=0;
                }
				$que = $this->db->query("SELECT ((DiscountPercent/100)* $total) as ls FROM posdiscount
WHERE DiscountType='GROSS' and round(DiscountCondition-$total)<0 order by ls desc limit 1;");		
                if($que->result_array()):
				foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];                    
				}			
				return ceil($obj);
                else:
                    $obj=0;
                endif;
                
			}
            
        function GetConstType($param)
			{	
				$que = $this->db->query("select ConstType as ls from x5cConst where ConstId='$param'");				
			
				foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];
				}			
				return $obj;
			}
        function TotalWithoutDisc()
			{	
				$que = $this->db->query("select sum(gross) as ls from posmtrantmp where Discount<1 and CreateBy='$this->userid'");				
			     $obj=0;
                if($que->result_array()):
                    foreach ($que->result_array() as $row)
                    {
                        $obj =  $row['ls'];
                    }			
                endif;
				return $obj;
			}
        function GetReference($param)
			{	
				$que = $this->db->query("select reference as ls from x5cConst where ConstId='$param'");				
			
				foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];
				}			
				return $obj;
			}
        
        function GetFormula($param)
			{	
				$que = $this->db->query("select reference as ls from x5cConst where ConstId='$param'");				
			
				foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];
				}			
				return $obj;
			}
        
        function CheckUnvalidationPost()
			{	
				$query = $this->db->query("select * from x5cPosting where ValidationStatus='N'");							
				 if($query->num_rows()>0)
                    {
                        return $query->result_array();
                    } 
			}
        
        
        
        function FinishPosting($param1,$param2)
			{					
                $table = $param1;
                
                $query = $this->db->query("update $table set ValidationStatus='Y' where PostId='$param2'");
                if($query)
                    {
                        return true;					
                    }
                        else
                    {
                        return false;
                    }
            }
        
      
        function ADD($table,$empl)
        {          
            $que = $this->db->query("");							            
            foreach ($que->result_array() as $row)
            {
                $total = $row['Total'];
            }
            return ceil($total+$salary); 
        }
            
        function THP($empl)
        {
            $salary = $this->GetSalary($empl);
            $que = $this->db->query("select sum(a.PrincipalAmount) as Total from x5cemployeedetails a join x5cConst b on a.ConstId=b.ConstId and b.GroupCode='THP' where EmployeeId='$empl';");							            
            foreach ($que->result_array() as $row)
            {
                $total = $row['Total'];
            }
            return ceil($total+$salary);            
        }
        function THPDetails($empl)
        {            
            $que = $this->db->query("select a.ConstId,b.ConstName,a.PrincipalAmount from x5cemployeedetails a join x5cConst b on a.ConstId=b.ConstId and b.GroupCode='THP' where EmployeeId='$empl';");							            
            if($que->num_rows()>0)
                    {
                        return $que->result_array();
                    }             
        }
        function ADDDetails($empl)
        {            
            $que = $this->db->query("select a.ConstId,b.ConstName,a.PrincipalAmount from x5cemployeedetails a join x5cConst b on a.ConstId=b.ConstId and b.GroupCode='ADD' where EmployeeId='$empl';");							            
            if($que->num_rows()>0)
                    {
                        return $que->result_array();
                    }             
        }
         
        function POTDetails($empl)
        {
            $salary = $this->GetSalary($empl);
            $que = $this->db->query("select a.ConstId,b.ConstName,a.PrincipalAmount from x5cemployeedetails a join x5cConst b on a.ConstId=b.ConstId and b.GroupCode='POT' where EmployeeId='$empl';");							            
            if($que->num_rows()>0)
                    {
                        return $que->result_array();
                    }             
        }
           
        function GetAmountPosting($period,$column,$empl)
        {
            $table = $this->GetPostingByPeriod($period);
            if ($this->db->field_exists($column, $table))
                {
                     
            $que = $this->db->query("select $column as ls from $table where EmployeeId='$empl'");							         foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];
				}			
				return $obj; 
                }
                     
        }
        
        function GetPostingByPeriod($period)
			{	
				$que = $this->db->query("select TableReference as ls from x5cPosting where PostPeriod='$period'");				
			
				foreach ($que->result_array() as $row)
				{
					$obj =  $row['ls'];
				}			
				return $obj;
			}
            
        function GeneratePosting($param)
        {
            $PostId = $param;
            $table = 'x5cPosting'.$PostId;
            
            //fase pertama create table
            $this->db->query("create table $table select EmployeeId,EmployeeName,Division,Department,FunctionalGroup,
            EmployeeSalary,PaymentMethod,PaymentAccount,PaymentBank from x5cEmployee");
            
            //fase kedua alter table by const
            $que = $this->db->query("select * from x5cConst");							
            foreach ($que->result_array() as $row)
            {
                $column =  $row['ConstId'];
                $columnAcc =  $row['ConstId'].'_ACCOUNT';
                $columnComp =  $row['ConstId'].'_COMPANY';
                $this->db->query("alter table $table add column $column decimal(16,2) default 0");   
                $this->db->query("alter table $table add column $columnAcc char(20) default ''");
                $this->db->query("alter table $table add column $columnComp decimal(16,2) default 0;");                                
            }		
            $this->db->query("alter table $table add column Overtime int(11) default 0");   
            $this->db->query("alter table $table add column OvertimePay decimal(16,2) default 0;"); 
            $this->db->query("alter table $table add column BackPay decimal(16,2) default 0;");
            $this->db->query("alter table $table add column Abstaint int(11) default 0");
            $this->db->query("alter table $table add column AbstaintPay decimal(16,2) default 0;");
            
            //fase ketiga update data posting
            $payroll = $this->db->query("select * from $table");	
            foreach ($payroll->result_array() as $roll)
            {
                $emplid = $roll['EmployeeId'];
                $details = $this->db->query("select * from x5cEmployeeDetails where EmployeeId='$emplid'");	
                foreach ($details->result_array() as $det)
                    {
                        $constid = $det['ConstId'];
                        $constidcompany = $det['ConstId']."_COMPANY";
                        $constAcc = $det['ConstId']."_ACCOUNT";
                        $employee = $det['PrincipalAmount'];
                        $company = $det['PrincipalAmountCompany'];
                        $account = $det['AccountId'];
                        $this->db->query("update $table set `$constid`='$employee',`$constidcompany`='$company',`$constAcc`='$account' where EmployeeId='$emplid'");
                    }
            }		
  
        }
        
        
               
	}