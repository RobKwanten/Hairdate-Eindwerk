<?php


namespace App\Controller;


use App\Repository\AfspraakRepository;
use App\Repository\AgendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AgendaController extends AbstractController
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



    public function getAgenda(Request $request, AfspraakRepository $afspraakRepository, AgendaRepository $agendaRepository)
    {
        $datum = $_GET['datum'];
        $kapper= $_GET['kapper'];
        $afspraken = $afspraakRepository->findAllAfsprakenByDate($datum,$kapper);
        $openingsuren = $agendaRepository->findAgendaByDate($datum,$kapper);
        $openingstijd= strtotime(date_format($openingsuren[0]['openingstijd'], "H:i:s"));
        $sluitingstijd= strtotime(date_format($openingsuren[0]['sluitingstijd'], "H:i:s"));
        $afspraakDuur=15;
        $begintijden=[];
        $eindtijden=[];

        foreach ($afspraken as $afspraak){
            array_push($begintijden,strtotime(date_format($afspraak["begintijd"], "H:i:s")));
            array_push($eindtijden,strtotime(date_format($afspraak["eindtijd"], "H:i:s")));
        }


        $beschikbareUren= [];


        while (strtotime("+".$afspraakDuur." minutes",  $openingstijd)<=$sluitingstijd){
            $afspraakTeller=0;
            if (!in_array(strtotime("+".$afspraakDuur." minutes", $openingstijd), $begintijden)){
                array_push($beschikbareUren, date("H:i:s",$openingstijd));
                $openingstijd = strtotime("+15 minutes", $openingstijd);
            } else {
                $openingstijd = strtotime("+30 minutes", $openingstijd);
                $duurTegengekomenAfspraak= $eindtijden[$afspraakTeller]-$begintijden[$afspraakTeller];
                $duurTegengekomenAfspraak = date("i", $duurTegengekomenAfspraak);
                $openingstijd=strtotime("+".$duurTegengekomenAfspraak." minutes",$openingstijd);
                $afspraakTeller++;
            }

        }

        return $this->json($beschikbareUren,'201', ['access-control-allow-origin'=>'*']);
    }

}