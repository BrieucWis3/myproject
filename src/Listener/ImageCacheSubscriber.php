<?php
namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Property;

class ImageCacheSubscriber implements EventSubscriber {

  /**
   * @var CacheManager
   */
  private $cacheManager;

  /**
   * @var UploaderHelper
   */
  private $uploaderHelper;

  public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
  {
    $this->cacheManager=$cacheManager;
    $this->uploaderHelper=$uploaderHelper;
  }

  public function getSubscribedEvents()
  {
    return [
      'preRemove',
      'preUpdate'
    ];
  }

  public function preRemove(LifecycleEventArgs $args)
  {
    $entity=$args->getEntity();
    if(!$entity instanceof Property)
    {
      return;
    }
    //die($entity->getFilename());
    $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));

  }

  public function preUpdate(PreUpdateEventArgs $args)
  {
    $entity=$args->getEntity();
    if(!$entity instanceof Property)
    {
      return;
    }
    if($entity->getImageFile() instanceof UploadedFile)
    {
      //die($entity->getFilename());
      $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

  }

}

 ?>