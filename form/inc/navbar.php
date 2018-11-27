<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">TOUR DE FRANCE 🚲</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="../../blindex.php">Menu</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Consultation</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../coureur/consulter_coureur.php">Coureur</a>
          <a class="dropdown-item" href="../coureur/consulter_saisir_equipe.php">Sponsor</a>
          <a class="dropdown-item" href="../classement/classement.php">Classement</a>
          <a class="dropdown-item" href="../participant/consulter_participant.php">Participant</a>
          <a class="dropdown-item" href="../coureur/consulter_pays.php">Pays</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Création</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../coureur/creer_coureur.php">Coureur</a>
          <a class="dropdown-item" href="../sponsor/creer_sponsor_choix.php">Sponsor</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Statistiques</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../stat/pays_visités.php">Pays</a>
          <a class="dropdown-item" href="../stat/ville_etape.php">Etapes</a>
        </div>
      </li>
    </ul>
    <button class="pull-right btn btn-light" onclick="javascript:history.back()">⬅️</button>
  </div>
</nav>
