<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#suggest" aria-expanded="true" aria-controls="edit">
                Suggest pathway
            </button>
        </h5>
    </div>

    <div id="suggest" class="collapse hide <?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT) === 'suggest' ? 'show' : ''; ?>" data-parent="#accordion">
        <div class="card-body">
            <form action="/suggest" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="suggest-form-pathway" class="col-sm-2 col-form-label">Pathway</label>
                    <div class="col-sm-10">
                        <textarea name="pathway" id="suggest-form-pathway" class="form-control"></textarea>
                        <small class="form-text text-muted">
                          Insert your pathway suggestion into the form or upload a PDF file containing your pathway. Please express your pathway as a sequence of steps of the form <em>... &rArr; ...</em>, <strong>possibly using Z-syntax</strong> (see the <a href="/guide">/guide</a> web page). You will  be contacted at <a href="mailto:<?= \Mitopaths\Session::getUser()->getEmail() ?>"><?= \Mitopaths\Session::getUser()->getEmail() ?></a>.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="suggest-form-pathway-pdf" class="col-sm-2 col-form-label">PDF</label>
                    <div class="col-sm-10">
                        <input type="file" name="pathway-file" id="suggest-form-pathway-pdf" class="form-control" accept="application/pdf"/>
                        <small class="form-text text-muted">
                            You may optionally send a PDF file containing your pathway.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Suggest</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
