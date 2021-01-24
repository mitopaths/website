<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Mitopaths</title>
        
        <?php $this->view('head'); ?>
    </head>
    
    <body>
        <header>
            <?php $this->view('navbar'); ?>
        </header>

        <main class="page" id="page-search">
            <div class="container">
<h2>API Documentation</h2>
<p>This document describes how to interact with Mitopaths through the search API mechanism. Data about molecules, proteins and pathways can be automatically retrieved by using the freely available API, which responds to HTTP GET requests by sending a simple JSON document with the requested information.</p>
<p>API is available at <strong>/API/search</strong>, and requires the following parameters:</p>
<ul>
<li><strong>q: </strong>query string used for search (can be a protein/pathway name, piece of name, etc), or * (star) to retrieve all of the information</li>
</ul>
<p>and accepts the following optional parameters:</p>
<ul>
<li>filters: array of filters (see dedicated section)</li>
<li>page: page number, for pagination (<em>deafult: 0</em>)</li>
<li>page_size: page size, for pagination (<em>default: 10</em>)</li>
</ul>
<h3>Filter API</h3>
<p>Filters allow returning only results matching a specific criterion, for instance only proteins or only pathways. To specify&nbsp;<em>conjunctive</em> filters it is enough to place multiple copies of the parameter in the query string:</p>
<blockquote>
<code>/API/search?q=*&amp;filters[]=type:pathway&amp;filters[]=category:"Energy+Metabolism"</code>
</blockquote>
<p>It is also possible to specify&nbsp;<em>disjunctive</em> filters by using&nbsp;<em>OR</em>:</p>
<blockquote>
<code>/API/search?q=*&amp;filters[]=type:(pathway+OR+protein)</code>
</blockquote>
<p>Mitopaths uses the&nbsp;<a href="https://lucene.apache.org/core/2_9_4/queryparsersyntax.html">Lucene Syntax</a>, which serves as a comprehensive guide about how to structure queries.</p>
<h2>Response Format</h2>
<p>Response is a JSON defining the following fields:</p>
<ul>
<li><strong>q:</strong> query string requested by the client</li>
<li><strong>results</strong>: number of results</li>
<li><strong>page</strong>: page number, for pagination</li>
<li><strong>page_size</strong>: number of items per page, for pagination</li>
<li><strong>items</strong>: array of matching items (see details below)</li>
<li><strong>facet_fields</strong>: dictionary of facets, used as statistical information of for filtering (see details below)</li>
</ul>
<h3>Items Format</h3>
<p>Attributes in an item depend on the type of item. Every items share the following fields:</p>
<ul>
<li><strong>id</strong>: Mitopaths identifier</li>
<li><strong>name</strong>: name of the protein/pathway</li>
<li><strong>type</strong>: type of item, one of&nbsp;<em>molecule, protein, mutated_protein, pathway, mutated_pathway</em></li>
<li><strong>description:</strong> textual description provided by the editor</li>
</ul>
<p>Pathways and deregulated pathways also define the following attributes:</p>
<ul>
<li><strong>theorem</strong>: main theorem, in Z-syntax (right arrow symbol is encoded as&nbsp;<em>rArr</em>)</li>
<li><strong>steps</strong>: array of demonstrative and biological steps, each one written in Z-syntax</li>
<li><strong>category</strong>: array of names of categories/mitochondrial processes to which the pathway belongs</li>
</ul>
<p>Proteins variants also define an&nbsp;<strong>original_protein</strong> attribute containing the name of the protein they are a mutation of. Similarly, deregulated pathways expose the name of their&nbsp;<strong>original_pathway</strong>.</p>
<h3>Facet Fields</h3>
<p>Mitopaths search API also returns some aggregated information. The&nbsp;<strong>facet_fields</strong> attribute dictionary defines the following fields:</p>
<ul>
<li><strong>type_facet</strong>: for every item type (<em>molecule, protein, mutated_protein, pathway, mutated_pathway)</em>, the number of matching items of that type</li>
<li><strong>category_facet</strong>: for every category, the number of matching pathways in that category (categories with 0 matching pathways are omitted)</li>
<li><strong>original_protein_facet</strong>: for each protein, the number of its mutations matching the query (omitted for proteins not having a mutation)</li>
<li><strong>original_pathway_facet</strong>: for each pathway (name), the number of mutations (pathways without mutations are omitted)</li>
</ul>

<h2>Some examples</h2>
<code>/API/search?q=*&amp;page_size=10&amp;filters[]=type:(protein+OR+pathway)</code>
Matches every protein and every pathway, returns first 10 elements:
<pre style="max-height: 350px; overflow: auto; background-color: #EEE">
{
  "q": "*",
  "response_time": 19,
  "results": 90,
  "page": 0,
  "page_size": 10,
  "items": [
    {
      "id": "protein_0463a1dad13580695be3ac791f533ffb",
      "name": "AFG3L2",
      "type": "protein",
      "description": "AFG3-like protein 2",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:Q9Y4W6"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_6a6cd719ce54c3a00d3f4e862a39373a",
      "name": "Bax",
      "type": "protein",
      "description": "Apoptosis regulator BAX\r\n",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:Q07812"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_21679e33cc9b0e290a6401f1b8569d43",
      "name": "Bcl-Xl",
      "type": "protein",
      "description": "Bcl-2-like protein 1",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:Q07817"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_7b7f6b6a3c8b116e66b92d0b18780e4f",
      "name": "BCS1L",
      "type": "protein",
      "description": "Mitochondrial chaperone BCS1",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:Q9Y276"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_e6ebc89461d5461dfec291971b4fc9fc",
      "name": "CCDC109B",
      "type": "protein",
      "description": "Calcium uniporter regulatory subunit MCUb, mitochondrial",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:Q9NWR8"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_5d729cdf1147cb8c75db57bafd85d181",
      "name": "CHCHD4",
      "type": "protein",
      "description": "Mitochondrial intermembrane space import and assembly protein 40",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:Q8N4Q1"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_b63076c96b71d1a01717b23322a90f6d",
      "name": "COX4I1",
      "type": "protein",
      "description": "Cytochrome c oxidase subunit 4 isoform 1, mitochondrial",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:P13073"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_12101ce033797f8ec6713a71980bf47e",
      "name": "CYC1",
      "type": "protein",
      "description": "Cytochrome c1, heme protein, mitochondrial",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:P08574"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_f505858a409290e352e4b3ad9ca8918e",
      "name": "CYCS",
      "type": "protein",
      "description": "Cytochrome c",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:P99999"
      ],
      "_highlighting": []
    },
    {
      "id": "protein_de8ea752543acd6088750e2e11bffff9",
      "name": "CYTB",
      "type": "protein",
      "description": "Cytochrome b",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:P00156"
      ],
      "_highlighting": []
    }
  ],
  "facet_fields": {
    "type_facet": {
      "protein": 69,
      "pathway": 21,
      "category": 0,
      "molecule": 0,
      "mutated_pathway": 0,
      "mutated_protein": 0
    },
    "category_facet": {
      "Ca2+ signalling": 5,
      "Transport of small molecules": 5,
      "Energy Metabolism": 3,
      "Ions exchange": 3,
      "Mitophagy": 3,
      "Antioxidant system": 2,
      "Apoptosis": 2,
      "Fusion/Fission": 2,
      "Oxidative phosphorylation": 2,
      "Protein Translocation": 2,
      "Protein turnover": 2,
      "ROS homeostasis": 2
    },
    "original_protein_facet": {
      "MFN2": 0,
      "PARK6": 0
    },
    "original_pathway_facet": {
      "MFN2 homo-oligomerization": 0
    }
  }
}
</pre>

<code>/API/search?q=MFN2</code>
Searhces for <code>MFN2</code>, hence both the molecule and the pathways containing it:
<pre style="max-height: 350px; overflow: auto; background-color: #EEE">
{
  "q": "MFN2",
  "response_time": 31,
  "results": 6,
  "page": 0,
  "page_size": 10,
  "items": [
    {
      "id": "protein_b02f8550e05f4c407fae663bc7e7d572",
      "name": "MFN2",
      "type": "protein",
      "description": "Mitofusin-2",
      "geneontology link_attr": [
        "http://amigo.geneontology.org/amigo/gene_product/UniProtKB:O95140"
      ],
      "_highlighting": {
        "name": [
          "<span class=\"highlight\">MFN2</span>"
        ]
      }
    },
    {
      "id": "pathway_ba74f024c19ea75245338d760a41c0fc",
      "name": "MFN1-MFN2 oligomerization",
      "type": "pathway",
      "theorem": "MFN1 & MFN2 & GTP & GTP &rArr; (MFN1 * MFN2)",
      "steps": [
        "MFN1 & MFN2 & GTP & GTP &rArr; (MFN1 * GTP) & (MFN2 * GTP)",
        "(MFN1 * GTP) & (MFN2 * GTP) &rArr; (MFN1 * Pi) & (MFN2 * Pi) & GDP & GDP",
        "(MFN1 * Pi) & (MFN2 * Pi) &rArr; (MFN1 * MFN2)"
      ],
      "category": [
        "Fusion/Fission"
      ],
      "_highlighting": {
        "name": [
          "MFN1-<span class=\"highlight\">MFN2</span> oligomerization"
        ],
        "theorem": [
          "<span class=\"highlight\">MFN1 & MFN2 & GTP & GTP &rArr; (MFN1 * MFN2)</span>"
        ],
        "steps": [
          "<span class=\"highlight\">MFN1 & MFN2 & GTP & GTP &rArr; (MFN1 * GTP) & (MFN2 * GTP)</span>",
          "<span class=\"highlight\">(MFN1 * GTP) & (MFN2 * GTP) &rArr; (MFN1 * Pi) & (MFN2 * Pi) & GDP & GDP</span>",
          "<span class=\"highlight\">(MFN1 * Pi) & (MFN2 * Pi) &rArr; (MFN1 * MFN2)</span>"
        ]
      }
    },
    {
      "id": "pathway_ddfc5c7957769e76ac791e350780f315",
      "name": "MFN2 homo-oligomerization",
      "type": "pathway",
      "theorem": "MFN2 & MFN2 & GTP & GTP &rArr; (MFN2 * MFN2)",
      "steps": [
        "MFN2 & MFN2 & GTP & GTP &rArr; (MFN2 * GTP) & (MFN2 * GTP)",
        "(MFN2 * GTP) &rArr; (MFN2 * Pi) & (MFN2 * Pi) & GDP & GDP",
        "(MFN2 * Pi) & (MFN2 * Pi) &rArr; (MFN2 * MFN2)"
      ],
      "category": [
        "Fusion/Fission"
      ],
      "_highlighting": {
        "name": [
          "<span class=\"highlight\">MFN2</span> homo-oligomerization"
        ],
        "theorem": [
          "<span class=\"highlight\">MFN2 & MFN2 & GTP & GTP &rArr; (MFN2 * MFN2)</span>"
        ],
        "steps": [
          "<span class=\"highlight\">MFN2 & MFN2 & GTP & GTP &rArr; (MFN2 * GTP) & (MFN2 * GTP)</span>",
          "<span class=\"highlight\">(MFN2 * GTP) &rArr; (MFN2 * Pi) & (MFN2 * Pi) & GDP & GDP</span>",
          "<span class=\"highlight\">(MFN2 * Pi) & (MFN2 * Pi) &rArr; (MFN2 * MFN2)</span>"
        ]
      }
    },
    {
      "id": "mutated_pathway_9611ef89f7380e2266da80294ab711b9",
      "name": "Reduced MFN2 activity",
      "type": "mutated_pathway",
      "original_pathway": "MFN2 homo-oligomerization",
      "theorem": "R707WMFN2 & R707WMFN2 & GTP & GTP &rArr; R707WMFN2 & R707WMFN2 & GTP & GTP",
      "steps": [
        "R707WMFN2 & R707WMFN2 & GTP & GTP &rArr; (R707WMFN2 * GTP) & (R707WMFN2 * GTP)",
        "(R707WMFN2 * GTP) & (R707WMFN2 * GTP) &rArr; R707WMFN2 & R707WMFN2 & GTP & GTP"
      ],
      "category": [
        "Fusion/Fission"
      ],
      "_highlighting": {
        "name": [
          "Reduced <span class=\"highlight\">MFN2</span> activity"
        ],
        "original_pathway": [
          "<span class=\"highlight\">MFN2</span> homo-oligomerization"
        ]
      }
    },
    {
      "id": "mutated_protein_b1d72ede0f0676eb17176d492845706d",
      "name": "R707WMFN2",
      "type": "mutated_protein",
      "original_protein": "MFN2",
      "description": "Missense mutation R -> W",
      "_highlighting": {
        "original_protein": [
          "<span class=\"highlight\">MFN2</span>"
        ]
      }
    },
    {
      "id": "pathway_7e30b86e96a688b886846b252acb2090",
      "name": "MFNs-mediated mitophagy",
      "type": "pathway",
      "theorem": "PARK6 & PARK6 & TOMM40 & Phos & Phos & Phos & PRKN & UBE2s & UBE2s & (MFN1 * MFN2) & SQSTM1 & MAP1LC3A &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1 * MAP1LC3A)",
      "steps": [
        "PARK6 & PARK6 &rArr; (PARK6 * PARK6)",
        "(PARK6 * PARK6) & TOMM40 &rArr; (PARK6 * PARK6 * TOMM40)",
        "(PARK6 * PARK6 * TOMM40) & Phos & Phos &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40)",
        "((Phos * PARK6) * (Phos * PARK6) * TOMM40) & PRKN &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & PRKN",
        "((Phos * PARK6) * (Phos * PARK6) * TOMM40) & PRKN & Phos &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN)",
        "((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & UBE2s & (MFN1 * MFN2) &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & ((Phos * PRKN) * UBE2s) & (MFN1 * MFN2)",
        "((Phos * PARK6) * (Phos * PARK6) * TOMM40) & ((Phos * PRKN) * UBE2s) & (MFN1 * MFN2) &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s)",
        "((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s) & UBE2s &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s)",
        "((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s) & SQSTM1 &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1)",
        "((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1) & MAP1LC3A &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1 * MAP1LC3A)"
      ],
      "category": [
        "Mitophagy"
      ],
      "_highlighting": {
        "theorem": [
          "<span class=\"highlight\">PARK6 & PARK6 & TOMM40 & Phos & Phos & Phos & PRKN & UBE2s & UBE2s & (MFN1 * MFN2) & SQSTM1 & MAP1LC3A &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1 * MAP1LC3A)</span>"
        ],
        "steps": [
          "<span class=\"highlight\">((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & UBE2s & (MFN1 * MFN2) &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & ((Phos * PRKN) * UBE2s) & (MFN1 * MFN2)</span>",
          "<span class=\"highlight\">((Phos * PARK6) * (Phos * PARK6) * TOMM40) & ((Phos * PRKN) * UBE2s) & (MFN1 * MFN2) &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s)</span>",
          "<span class=\"highlight\">((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s) & UBE2s &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s)</span>",
          "<span class=\"highlight\">((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s) & SQSTM1 &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1)</span>",
          "<span class=\"highlight\">((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1) & MAP1LC3A &rArr; ((Phos * PARK6) * (Phos * PARK6) * TOMM40) & (Phos * PRKN) & (MFN1 * MFN2 * UBE2s * UBE2s * SQSTM1 * MAP1LC3A)</span>"
        ]
      }
    }
  ],
  "facet_fields": {
    "type_facet": {
      "pathway": 3,
      "mutated_pathway": 1,
      "mutated_protein": 1,
      "protein": 1,
      "category": 0,
      "molecule": 0
    },
    "category_facet": {
      "Fusion/Fission": 3,
      "Mitophagy": 1,
      "Antioxidant system": 0,
      "Apoptosis": 0,
      "Ca2+ signalling": 0,
      "Energy Metabolism": 0,
      "Ions exchange": 0,
      "Oxidative phosphorylation": 0,
      "Protein Translocation": 0,
      "Protein turnover": 0,
      "ROS homeostasis": 0,
      "Transport of small molecules": 0
    },
    "original_protein_facet": {
      "MFN2": 1,
      "PARK6": 0
    },
    "original_pathway_facet": {
      "MFN2 homo-oligomerization": 1
    }
  }
}
</pre>
            </div>
        </main>
    </body>
</html>
