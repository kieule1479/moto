<?php

$link = 'http://www.sjc.com.vn/xml/tygiavang.xml';
$xml = simplexml_load_file($link)->ratelist->city;

$xmlJSON = json_encode($xml);
$xmlArr = json_decode($xmlJSON, true);

$goldList = $xmlArr['item'];

$xhtml = '';
foreach ($goldList as $goldItem) {
    $goldItem = $goldItem['@attributes'];
    $xhtml .= '
    <tr>
        <td>'.$goldItem['type'].'</td>
        <td>'.$goldItem['buy'].'</td>
        <td>'.$goldItem['sell'].'</td>
    </tr>
    ';
}
?>


<div class="box mt-4">
    <h3 class="mb-1 text-danger">Giá vàng</h3>
    <div class="card card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th><b>Loại vàng</b></th>
                    <th><b>Mua vào</b></th>
                    <th><b>Bán ra</b></th>
                </tr>
            </thead>
            <tbody>

                <?php echo $xhtml; ?>

            </tbody>
        </table>
    </div>
</div>