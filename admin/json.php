<?php 
include "config.php";
$response =array();
$sql = "select * from  posord where property_id=$property_id";
$result = mysqli_query($conn, $sql);
$i=0;
while ($row = mysqli_fetch_assoc($result)) {
	$order_reference_id = $row['id'];
    $payload_type = $row['payload_type'];
    if($payload_type == "order"){
        $sql2 = "select * from  chmbil where order_reference_id=$order_reference_id";
        $result2 = mysqli_query($conn, $sql2);
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $response[$i]['payload_type'] = $payload_type;
            $response[$i]['order_reference_id'] = $order_reference_id;
            $response[$i]['CHMBIL'] = $row2;
            
            $sql3 = "select * from  chmord where order_reference_id=$order_reference_id";
            $result3 = mysqli_query($conn, $sql3);
            $j=0;
            while ($row3 = mysqli_fetch_assoc($result3)) {
                $response[$i]['CHMORD'][$j] = $row3;
                $CHANEL = $row3['CHANEL'];
                $j++;
            }

            $response[$i]['CHMKIM']=array();
            $sql5 = "select * from  chmkim where order_reference_id=$order_reference_id";
            $result5 = mysqli_query($conn, $sql5);
            $j=0;
            while ($row5 = mysqli_fetch_assoc($result5)) {
                $response[$i]['CHMKIM'][$j] = $row5;
                $j++;
            }

            $sql4 = "select * from  chmtax where order_reference_id=$order_reference_id";
            $result4 = mysqli_query($conn, $sql4);
            $j=0;
            while ($row4 = mysqli_fetch_assoc($result4)) {
                $response[$i]['CHMTAX'][$j] = $row4;
                $j++;
            }
            $response[$i]['CHMBIL']['CHANEL'] = $CHANEL;
            $i++;
        }
    }else if($payload_type == "Cancelled"){
        $flag = true;
        $sql2 = "select * from  urban_cancel where order_reference_id=$order_reference_id and new_state='Cancelled' order by order_reference_id";
        $result2 = mysqli_query($conn, $sql2);
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $response[$i]['payload_type'] = "cancel";
            $response[$i]['order_reference_id'] = $row2['order_reference_id'];
            $response[$i]['ORDNUB'] = $row2['order_id'];
            $response[$i]['ORDSTS'] = $row2['new_state'];
            unset($response[$i]['id']);
            $i++;
        }
    }
}
if(!$flag) $response[]['message'] = "success";
echo json_encode($response);
