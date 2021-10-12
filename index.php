<?php

use Grafikart\GuestBook\{
    GuestBook,
    Message
};
use Grafikart\Contact\Message as ContactMessage; // Alias
require_once 'class/Message.php';
require_once 'class/GuestBook.php';
require_once 'class/contact/Message.php';
$success = false;
$errors = null;
$demo = new ContactMessage(); // Liaison de Alias 
$guestbook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');
if (isset($_GET['username'], $_GET['message'])) {
    $message = new Message($_GET['username'], $_GET['message']);
    if ($message->isValid()) {    
        $guestbook->addMessage($message); // Ajouter ds le document text (messages.txt)
        $success = true;
        $_GET = []; // Pour vider les infos ds le formulaire si "$success"
    } else {
        $errors = $message->getErrors();
    }
}
$messages = $guestbook->getMessages(); // Affichage sur le Navigateur
$title = "Livre d'or";
require 'elements/header.php';
?>

<div class="container">
    <h1>Livre d'or</h1>

    <?php if ($success) : ?>
        <div class="alert alert-success">
            Merci pour votre message
        </div>
    <?php elseif (!empty($errors)) : ?>
        <div class="alert alert-danger">
            Formulaire invalide
        </div>
    <?php endif ?>

    <form action="./index.php" method="GET">
        <div class="form-group">
            <?php require_once 'class/Message.php'; ?>
            <input value="<?= htmlentities($_GET['username'] ?? '') ?>" type="text" name="username" placeholder="Votre pseudo" class="form-control">
            <?php if (isset($errors['username'])) : ?>
                <div class="article" style="color:red">
                    <?= $errors['username'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Votre pseudo" class="form-control"><?= htmlentities($_GET['message'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])) : ?>
                <div class="article" style="color:red">
                    <?= $errors['message'] ?>
                </div>
            <?php endif ?>
        </div>
        <button class="btn btn-primary">Envoyer</button>
    </form>

    <?php if(!empty($messages)): ?>
    <h1 class="mt-4">Vos messages</h1>
    
    <?php foreach($messages as $message): ?>
        <?= $message->toHTML() ?>
    <?php endforeach ?>

    <?php endif ?>

</div>

<?php require 'elements/footer.php'; ?>