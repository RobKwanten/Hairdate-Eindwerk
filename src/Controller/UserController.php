<?php


namespace App\Controller;


use App\Entity\Klant;
use App\Traits\MailerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    use MailerTrait;
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $em = $this->getDoctrine()->getManager();
        $content = json_decode($request->getContent(), false);

        $email= $content->email;
        $password= $content->password;
        $naam= $content->naam;
        $voornaam= $content->voornaam;
        $postcode= $content->postcode;
        $gemeente= $content->gemeente;
        $straat= $content->straat;
        $huisnr= $content->huisnr;
        $telnr= $content->telnr;

        $klant = new Klant();
        $klant ->setEmail($email)
            ->setPassword($passwordEncoder->encodePassword($klant, $password))
            ->setNaam($naam)
            ->setVoornaam($voornaam)
            ->setPostcode($postcode)
            ->setGemeente($gemeente)
            ->setStraat($straat)
            ->setHuisnr($huisnr)
            ->setTelnr($telnr)
            ->setRegKey('renew');
        //$link = 'http://localhost:8000/bevestig?reg_key='.$klant->getRegKey();

        $em->persist($klant);
        $em->flush();
        //$this->sendMail($email, $link);
        return $this->json(sprintf('Klant created'),'201', ['access-control-allow-origin'=>'*']);
    }
}