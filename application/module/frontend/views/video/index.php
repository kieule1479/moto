<?php
$xhtml = '';

//======== VIDEO =========
foreach ($this->videos as $video) {

    $id   = $video['id'];
    $name = $video['name'];
    $img  = $video['picture'];
    $link = URL::createLink('frontend', 'video', 'detail', ['video_id' => $id]);

    $xhtmlVideos .= '
                    <div class="itemnoidungs saovan_4 kk_mg">
                        <div class="img kk_poisan">
                            <a href="' . $link . '" title="' . $name . '"><img " src="' . URL_PUBLIC . 'files/video/' . $img . '" alt="' . $name . '"></a>
                            <a href="' . $link . '" class="kk_color fas fa-play-circle"></a>
                        </div>
                        <div class="kk_border">
                            <br>
                             <p class="tieude"><a href="' . $link . '" title="' . $name . '">' . $name . '</a></p>
                         </div>
                   </div>
                 ';
}
//======== END NEWS =========
?>

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Video</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        
        <div class="chia2" style="width:100%;float:left;">
            <div class="_2item">
                <?php echo $xhtmlVideos ?>
            </div>
            <div class="clear"></div>

        </div>
    </div>

</div><!-- END VIDEO -->