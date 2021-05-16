<?php
require_once('data.php');

 $currentBreadCrumb = $arrBreadCrumb[$menuCurrent];
 
 echo '<pre>';
 print_r($currentBreadCrumb);
 echo '</pre>';

 echo $lengthBreadCrumb = count($currentBreadCrumb);


$xhtmlBreadCrumb = '';
switch ($lengthBreadCrumb) {
    case 1:
        if ($menuCurrent == 'index') {
            $xhtmlBreadCrumb = sprintf('<span>Home</span>');
        } else {
            $xhtmlBreadCrumb = sprintf('
            <a href="index.php">Home</a>
            <span>></span>
            <span>%s</span>', $currentBreadCrumb[0]['name']);
        }
        break;
    case 2:
        $xhtmlBreadCrumb = sprintf('
        <a href="index.php">Home</a>
        <span>></span>
        <a href="%s">%s</a>
        <span>></span>
        <span>%s</span>', $currentBreadCrumb[0]['link'], $currentBreadCrumb[0]['name'], $currentBreadCrumb[1]['name']);
        break;
    case 3:
        $xhtmlBreadCrumb = '<a href="index.php">Home</a>';
        for ($i = 0; $i < $lengthBreadCrumb - 1; $i++) {
            $xhtmlBreadCrumb .= sprintf('
            <span>></span>
            <a href="%s">%s</a>
            ', $currentBreadCrumb[$i]['link'], $currentBreadCrumb[$i]['name']);
        }
        $xhtmlBreadCrumb .= sprintf('<span>></span><span>%s</span>', $currentBreadCrumb[$lengthBreadCrumb - 1]['name']);
        break;
}

?>
<div class="breadcrumb">
    <?php echo $xhtmlBreadCrumb; ?>
</div>