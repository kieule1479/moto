<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$link = 'https://vnexpress.net/rss/the-gioi.rss';

$xml = simplexml_load_file($link, 'SimpleXMLElement', LIBXML_NOCDATA);
$xmlJson    = json_encode($xml);
$xmlArr     = json_decode($xmlJson, 1);
$items = $xmlArr['channel']['item'];

$result = [];

foreach ($items as $item) {
    $tmp1 = [];
    $tmp2 = [];

    preg_match('/src="([^"]*)"/i', $item['description'], $tmp1);
    $pattern = '.*br>(.*)';
    preg_match('/' . $pattern . '/', $item['description'], $tmp2);

    $image = (isset($tmp1[1])) ? $tmp1[1] : '';
    $description = (isset($tmp2[1])) ? $tmp2[1] : $item['description'];

    $result[] = [
        'title' => $item['title'],
        'description' => $description,
        'pubDate' => date('d/m/Y H:i:s', strtotime($item['pubDate'])),
        'link' => $item['link'],
        'image' => $image
    ];
}

$xhtml = '';
foreach ($result as $item) {
    $title = $item['title'];
    $image = $item['image'];
    $date = $item['pubDate'];
    $description = $item['description'];
    $link = $item['link'];
    $xhtml .= '
    <div class="col-md-6 p-3">
        <div class="entry mb-1 clearfix">
            <div class="entry-image mb-3">
                <a href="' . $image . '" data-lightbox="image" style="background: url(' . $image . ') no-repeat center center; background-size: cover; height: 278px;"></a>
            </div>
            <div class="entry-title">
                <h3><a href="' . $link . '">' . $title . '</a></h3>
            </div>
            <div class="entry-content">
                ' . $description . '
            </div>
            <div class="entry-meta no-separator nohover">
                <ul class="justify-content-between mx-0">
                    <li><i class="icon-calendar2"></i> ' . $date . '</li>
                    <li>vnexpress.net</li>
                </ul>
            </div>
            <div class="entry-meta no-separator hover">
                <ul class="mx-0">
                    <li><a href="' . $link . '">Xem &rarr;</a></li>
                </ul>
            </div>
        </div>
    </div>
    ';
}
?>

<section id="content" class="bg-light">
    <div class="content-wrap pt-lg-0 pt-xl-0 pb-0">
        <div class="container clearfix">
            <div class="heading-block border-bottom-0 center pt-4 mb-3">
                <h3>Tin tức</h3>
            </div>
            <!-- Posts -->
            <div class="row grid-container infinity-wrapper clearfix">
                <?= $xhtml ?>
            </div>

            <!-- Infinity Scroll Loader
					============================================= -->
            <div class="text-center">
                <div class="page-load-status hovering-load-status">
                    <div class="css3-spinner infinite-scroll-request">
                        <div class="css3-spinner-ball-pulse-sync">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="alert alert-warning center infinite-scroll-last mx-auto" style="max-width: 20rem;">End of content</div>
                    <div class="alert alert-warning center infinite-scroll-error mx-auto" style="max-width: 20rem;">No more pages to load</div>
                </div>
            </div>
            <div class="center d-none">
                <a href="demo-modern-blog-2.html" class="load-next-posts"></a>
            </div>

        </div>

    </div>
</section>