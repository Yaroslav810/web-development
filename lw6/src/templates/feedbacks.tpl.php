<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin BINO</title>
    <link rel="stylesheet" href="./../../web/css/feedbacks-style.css" />
  </head>
  <body>
    <div class="feedbacks">
      <form class="feedbacks__form">
        <div class="form-row">
          <input
                  type="email"
                  id="formEmail"
                  name="email"
                  class="form-field"
                  placeholder="Email"
                  value="<?php echo $this->args['email'] ?? ''; ?>"
          />
        </div>
        <button class="form-button button">Get data</button>
      </form>
      <div class="feedbacks__content">
        <?php if (isset($this->args)): ?>
          <?php if (isset($this->args['error'])): ?>
            <p class="feedbacks__error"><?php echo $this->args['error']; ?></p>
          <?php else: ?>
            <ul class="feedback__list">
              <?php foreach ($this->args as $key => $answer): ?>
                <li class="list__item">
                  <p class="list__item-title"><?php echo $key . ': '; ?></p>
                  <p class="list__item-answer"><?php echo $answer; ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
           <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>