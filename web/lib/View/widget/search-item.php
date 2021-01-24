<?php
switch ($item['type']) {
    case 'protein':
        $this->view('widget/search-protein', $_variables);
        break;
        
    case 'mutated_protein':
        $this->view('widget/search-mutated-protein', $_variables);
        break;
        
        
    case 'pathway':
        $this->view('widget/search-pathway', $_variables);
        break;
        
    case 'mutated_pathway':
        $this->view('widget/search-mutated-pathway', $_variables);
        break;
        
        
    case 'category':
        $this->view('widget/search-category', $_variables);
        break;
}
?>