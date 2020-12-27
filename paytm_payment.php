<?php
    require_once 'lib/core.php'; 
    if(isset($_GET['u_token']) && !empty($_GET['u_token'])&&isset($_GET['token']) && !empty($_GET['token']))
    {
        $USER_ID = $_GET['u_token'];
        $token = $_GET['token'];
        $sql="SELECT * from courses WHERE id=$token";
        $result = $conn->query($sql);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $charges = $row; 
        }
        $service_id = $charges['id'];
        $amt = $charges['price'];
        $sql = "insert into transactions(trans_text,status,u_id,service,service_id,amt) values('Paid for Web Development Training Program','Pending',$USER_ID,'Web Development Course',$service_id,'$amt')";
        if($conn->query($sql))
        {
            $insertId = $conn->insert_id;
            $txn_id = $insetId.$USER_ID.time();
            $sql="update transactions set order_id=$txn_id where id= $insertId";
            $conn->query($sql);
        } 
    }
    
?>
<div class="wrapper">
    <!-- Sidebar  -->
     
    <!-- Page Content  -->
    <div id="content">
        
            <div class="panel panel-default" style="margin:50%">  
                <div class="panel-body"> 
                    <?php
                        if(isset($USER_ID)&&isset($charges)&&isset($txn_id)&&!empty($txn_id))
                        {
                    ?>
                            <form method="post" action="lib/PaytmKit/pgRedirect.php" id="paymentForm">
                                <input class="form-control" id="ORDER_ID" tabindex="1" maxlength="20" size="20"  name="ORDER_ID" autocomplete="off"  type="hidden"  value="<?=$txn_id?>">
                                <input type="hidden" class="form-control" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?=$USER_ID?>">
                                <input type="hidden" class="form-control"  id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
                                <input type="hidden"  class="form-control" id="CHANNEL_ID" tabindex="4" maxlength="12"  size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
                                <input type="hidden" class="form-control" title="TXN_AMOUNT" tabindex="10" type="text" name="TXN_AMOUNT" type="hidden" value="<?=$charges['price']?>"> 
                            </form>
                    <?php
                        }
                    ?>
                   
                </div> 
            </div> 
            
<?php
    require_once 'js-links.php';        
?>

<script>
    $("#paymentForm").submit()
</script>