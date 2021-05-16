<?php
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$parameters = [ 
  'start' => '1',
  'limit' => '5000',
  'convert' => 'USD'
];

$headers = [
  'Accepts: application/json',
  'X-CMC_PRO_API_KEY: a4fff16d-f8e6-416b-830d-0fc0dd5b27d2'
];
$qs = http_build_query($parameters); // query string encode the parameters
$request = "{$url}?{$qs}"; // create the request URL


$curl = curl_init(); // Get cURL resource
// Set cURL options
curl_setopt_array($curl, array(
  CURLOPT_URL => $request,            // set the request URL
  CURLOPT_HTTPHEADER => $headers,     // set the headers 
  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
));

$response = curl_exec($curl); // Send the request, save the response
//print_r(json_decode($response)); // print json decoded response

 $arr = (json_decode($response, true));
 $arrData = $arr['data'];

 $i =0;
 $xhtmlCoin='';
foreach ($arrData as $key => $value)
{
    $i++;
    $name= $value['name'];
    $price= round($value['quote']['USD']['price'],2);
    $change = round($value['quote']['USD']['percent_change_24h'], 2);

    $class = 'text-danger';
    if($change >= 0){
        $class = 'text-success';
    }

    $xhtmlCoin .='
            <tr>
                <td>'.$name.'</td>
                <td>$'.$price.'</td>
                <td><span class="'.$class.'">'.$change.'%</span></td>
             </tr>
    '; 
    if($i==20){
        break;
    }
}

curl_close($curl); // Close request


//!=================================================== END PHP =======================================================
?>
<div class="box mt-4">
    <h3 class="mb-1 text-success">Giá coin</h3>
    <div class="card card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th><b>Name</b></th>
                    <th><b>Price</b></th>
                    <th><b>Change (24h)</b></th>
                </tr>
            </thead>
            <tbody>

            <?php echo $xhtmlCoin; ?>
                <!-- <tr>
                    <td>Bitcoin</td>
                    <td>$11,704.1800</td>
                    <td><span class="text-success">2.82%</span></td>
                </tr> -->


            </tbody>
        </table>
    </div>
</div>