<?php

namespace Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;

use ArangoDBClient\Document;
use ArangoDBClient\CollectionHandler;

class IndexController extends Controller
{
  public function index(Application $app)
  {
  	$your_collection_name = 'noticias';
    $collectionHandler = $app['adb-h']->handleCollection();
    $collection = $collectionHandler->get( $your_collection_name );

    //Your example on PR discussion
    //(https://github.com/arangodb/arangodb-php/blob/devel/tests/CollectionExtendedTest.php#L797)
    //The result is an empty collection
    $exampleDocument = Document::createFromArray(['someOtherAttribute' => 'someOtherValue']);
    $cursor          = $collectionHandler->byExample($collection->getId(), $exampleDocument, ['_flat' => true]);
    $array = $cursor->getAll();

    //Uncomment the line below to see the difference
    //The result is a collection with your all documents
    //$array = $collectionHandler->all( $your_collection_name )->getAll();

    return new JsonResponse( $array , 200);
  }
}