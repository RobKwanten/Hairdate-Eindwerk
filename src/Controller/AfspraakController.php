<?php


namespace App\Controller;


use App\Entity\Afspraak;
use App\Entity\DienstenKapper;
use App\Entity\Kapper;
use App\Entity\Klant;
use App\Repository\AfspraakRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AfspraakController extends AbstractController
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    private $serializer;

    public function __construct(TokenStorageInterface $tokenStorage, SerializerInterface $serializer)
    {
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
    }

    public function newAfspraak(Request $request){
        $em= $this->getDoctrine()->getManager();
        $content = json_decode($request->getContent(), false);

        $klantRepo = $this->getDoctrine()->getRepository(Klant::class);
        $kapperRepo = $this->getDoctrine()->getRepository(Kapper::class);
        $dienstRepo = $this->getDoctrine()->getRepository(DienstenKapper::class);

        $notities = $content->notities;
        $datum = $content->datum;
        $begintijd = $content->begintijd;
        $duur = $content->duur;

        $begintijd = strtotime($begintijd);
        $eindtijd= strtotime("+".$duur." minutes", $begintijd);

        $datum = date("Y-m-d", strtotime($datum));
        $begintijd = date("H:i:s",$begintijd);
        $eindtijd = date("H:i:s",$eindtijd);

        try {
            $datum = new \DateTimeImmutable($datum);
            $begintijd = new \DateTimeImmutable($begintijd);
            $eindtijd = new \DateTimeImmutable($eindtijd);
        } catch (\Exception $e) {
            //SCHRIJF ERROR
        }

        $klant = $content->Klant;
        $klant = $klantRepo->findOneBy(['id'=>$klant]);

        $kapper = $content->Kapper;
        $kapper = $kapperRepo->findOneBy(['id'=>$kapper]);

        $dienst = $content->Dienst;
        $dienst = $dienstRepo->findOneBy(['id'=>$dienst]);

        $afspraak = new Afspraak();
        $afspraak->setNotities($notities)
            ->setDatum($datum)
            ->setBegintijd($begintijd)
            ->setEindtijd($eindtijd)
            ->setKlant($klant)
            ->setKapper($kapper) 
            ->setDienst($dienst);

        $em->persist($afspraak);
        $em->flush();

        return $this->json(sprintf("Afspraak created"),'201', ['access-control-allow-origin'=>'*']);
    }

    public function getAfspraken(AfspraakRepository $repository){
        $id = $_GET['id'];
        $datum = date("Y-m-d");

        $afspraken = "hallo";

        return $this->json($datum,'201', ['access-control-allow-origin'=>'*']);
    }
}