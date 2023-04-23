<?php


namespace App\Security\Voter;

use App\Entity\Recipe;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RecipeVoter extends Voter 
{
  const ACCESS = "RECIPE_ACCESS";

  private $security;

  public function __construct(Security $security)
  {
    $this->security = $security;
  }

  protected function supports(string $attribute, $recipe): bool
  {
    // if(!in_array($attribute, [self::ACCESS])) {
    //   return false;
    // }
    // if(!$recipe instanceof Recipe){
    //   return false;
    // }
    // return true;

    return in_array($attribute, [self::ACCESS]) && $recipe instanceof Recipe;
  }

  protected function voteOnAttribute($attribute, $product, TokenInterface $token): bool
  {
    //on récupère l'utilisateur à partir du token
    $user = $token->getUser();

    if(!$user instanceof UserInterface) {
      return false;
    }

    //on vérifie si l'utilisateur est au moins un patient
    if($this->security->isGranted('ROLE_PATIENT')) return true;

    //on vérifie les permissions
    switch($attribute){
      case self::ACCESS:
        //on vérifie si le patient peut accéder à la page
        return $this->canAccess();
        break;
      default:
      return false;
        break;
    }
  }

  private function canAccess(){
    return $this->security->isGranted('ROLE_PATIENT');
  }
}


?>