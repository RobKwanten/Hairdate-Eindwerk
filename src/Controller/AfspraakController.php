<?php


namespace App\Controller;


use App\Entity\Afspraak;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AfspraakController extends AbstractController
{
    public function makeAfspraak(Request $request){
        $em= $this->getDoctrine()->getManager();
        $content = json_decode($request->getContent(), false);

        $notities = $content->notities;
        $datum = $content->datum;
        $begintijd = $content->begintijd;
        $begintijd= strtotime($content->begintijd);
        $eindtijd= strtotime("+30 minutes",$begintijd);
        $begintijd= date("h:i:s", $begintijd);
        $eindtijd= date("h:i:s",$eindtijd);
        $klant = $content->Klant;
        $kapper = $content->Kapper;
        $dienst = $content->Dienst;

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

        return $this->json(sprintf('Afspraak created'),'201', ['access-control-allow-origin'=>'*']);
    }

}