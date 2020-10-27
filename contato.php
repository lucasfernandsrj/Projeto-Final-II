<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    $titulo = "Contate-nos";
    include_once "templates/head.php";
    ?>
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="container my-5 py-5 z-depth-1">
                            <!--Section: Content-->
                            <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text">
                                <style>
                                    .map-container {
                                        height: 200px;
                                        position: relative;
                                    }

                                    .map-container iframe {
                                        left: 0;
                                        top: 0;
                                        height: 100%;
                                        width: 100%;
                                        position: absolute;
                                    }
                                </style>
                                <!--Google map-->
                                <div id="map-container-google-1" class="z-depth-1 map-container mb-5">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3675.43997888463!2d-43.10883378456529!3d-22.89713708501675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9983f20f147ded%3A0xf8e9098ab1c73cab!2sCentro%20Universit%C3%A1rio%20La%20Salle!5e0!3m2!1spt-BR!2sbr!4v1603764144415!5m2!1spt-BR!2sbr" 
                                            width="600" 
                                            height="450" 
                                            frameborder="0" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            aria-hidden="false" 
                                        tabindex="0">
                                    </iframe>
                                </div>
                                <!--Google Maps-->
                                <?php
                                if (isset($_SESSION['msgcontato'])) {
                                    echo $_SESSION['msgcontato'];
                                    unset($_SESSION['msgcontato']);
                                }
                                ?>
                                <!--Grid row-->
                                <div class="row">

                                    <!--Grid column-->
                                    <div class="col-lg-5 col-md-12 mb-0 mb-md-0">

                                        <h3 class="font-weight-bold">Contate-nos</h3>

                                        <p class="text-muted">Em casos de problemas ou dúvidas, basta entrar em contato pelo e-mail abaixo.</p>

                                        <p><span class="font-weight-bold mr-2">Email:</span><a href="">lucas.fernandes@sousalle.com.br</a></p>
                                        <p><span class="font-weight-bold mr-2">Telefone:</span><a href="">+21 000 000 000</a></p>

                                    </div>
                                    <!--Grid column-->
                                    <div class="col-lg-7 col-md-12 mb-4 mb-md-0">
                                        <form method="post"action="includes/addContact.php">
                                            <div class="row">
                                                <!--Grid column-->
                                                <div class="col-md-12">
                                                    <!-- Material outline input -->
                                                    <div class="md-form md-outline mt-3">
                                                        <label for="form-first-name">Nome Completo</label>
                                                        <input type="text" id="form-nome-contato" name="form-nome-contato" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <!-- Material outline input -->
                                                    <div class="md-form md-outline mt-3">
                                                        <label for="form-email">E-mail</label>
                                                        <input type="email" id="form-email-contato" name="form-email-contato" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <!-- Material outline input -->
                                                    <div class="md-form md-outline">
                                                        <label for="form-subject">Assunto</label>
                                                        <input type="text" id="form-assunto-contato" name="form-assunto-contato" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <!--Material textarea-->
                                                    <div class="md-form md-outline mb-3">
                                                        <label for="form-message" pl>Como podemos ajudá-lo?</label>
                                                        <textarea id="form-mensagem-contato" name="form-mensagem-contato" class="md-textarea form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="md-form md-outline mb-3">
                                                        <button type="submit" class="btn btn-success" name="btnContact">Enviar<i class="far fa-paper-plane"></i></button>
                                                    </div>
                                                </div>
                                                <!--Grid column-->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--Grid row-->
                            </section>
                            <!--Section: Content-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'templates/footer.php'; ?>
    <!-- SCRIPTS -->
    <?php require_once 'templates/frameworks.php'; ?>
</body>
</html>