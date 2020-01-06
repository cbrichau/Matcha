    </div>

    <footer class="d-flex flex-column flex-md-row p-3 px-md-4 mt-auto bg-white border-top shadow-lg">
      <p class="my-0 mr-md-auto font-weight-normal">Matcha 42/19 Coding School &copy; cbrichau &amp; nraziano 2019</p>
    </footer>

    <?php
      if ($_SESSION['is_logged'] === TRUE)
      {
        $userMng = new MUserMng();
        $userMng->update_last_activity();
      }
    ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  	<script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
  	<script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script>
  	<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin></script>

    <script src="<?php echo Config::JS_PATH.'notifications.js?'.time(); ?>"></script>
  </body>
</html>
