<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#contact" aria-expanded="true" aria-controls="edit">
              Contact Us
            </button>
        </h5>
    </div>

    <div id="contact" class="collapse hide <?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT) === 'contact' ? 'show' : ''; ?>" data-parent="#accordion">
        <div class="card-body">
          <form id="contact-us-form">
            <div class="form-group">
              <textarea id="contact-us-input" name="message" class="form-control" rows="5"></textarea>
              <small class="form-text text-muted">Use this form to notify some issue about the content of mitopatHs, or to contact our team. You will be contacted at <a href="mailto:<?= $user->getEmail(); ?>"><?= $user->getEmail(); ?></a>.</small>
              <button type="submit" class="btn btn-primary">Send</button>
            </div>
          </form>
        </div>
    </div>
</div>
