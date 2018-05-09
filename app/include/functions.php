<?php
// Object to Class object
function cast($destination, $sourceObject)
{
    if (is_string($destination)) {
        $destination = new $destination();
    }
    $sourceReflection = new ReflectionObject($sourceObject);
    $destinationReflection = new ReflectionObject($destination);
    $sourceProperties = $sourceReflection->getProperties();
    foreach ($sourceProperties as $sourceProperty) {
        $sourceProperty->setAccessible(true);
        $name = $sourceProperty->getName();
        $value = $sourceProperty->getValue($sourceObject);
        if ($destinationReflection->hasProperty($name)) {
            $propDest = $destinationReflection->getProperty($name);
            $propDest->setAccessible(true);
            $propDest->setValue($destination,$value);
        } else {
            $destination->$name = $value;
        }
    }
    return $destination;
}

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

     $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function albumPhotoShow($data){
    echo '<h1>'.$data[0]['album_name'] .'</h1>';
    echo '<div class="row" id="albumList">';
    foreach ($data as $items){
        ?>
        <a data-toggle="lightbox" data-gallery="single-images" class="col-sm-3" href="<?php echo URL_ROOT . $items['img_url']; ?>">
            <img class="img_100 img-thumbnail" src="<?php echo URL_ROOT . $items['thumb_url']; ?>">
        </a>
        <?php
    }
    echo '<div>';
}

function albumShow($data){
    echo '<div class="row" id="albumList">';
    foreach ($data as $items){
        ?>
        <a class="col-sm-3" id="albumLink-<?php echo $items['id']; ?>" href="<?php
        echo URL_ROOT . '/index/album&id=' .  $items['id']; ?>">
            <img src="<?php echo URL_ROOT . $items['album_thumb']; ?>" class="img_100 img-thumbnail">
            <div class="albumNameTag"><?php echo $items['name']; ?></div>
        </a>
        <?php
    }
    echo '<div>';
}