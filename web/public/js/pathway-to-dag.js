function pathway_to_dag(pathway) {
    function equal(A, B) {
        return expression_to_string(A) === expression_to_string(B);
    }
    
    function expression_to_array(expression) {
        if (expression._type === 'conjunction') {
            return expression.components;
        }
        return [expression];
    }
    
    
    
    
    
    var G = new Graph();
    G.addInteraction = function (interaction) {
        return G.addNode(interaction)
               .setAttribute('label', expression_to_string(interaction))
               .setAttribute('type', interaction._type)
               .setAttribute('position', interaction.position);
    }

    
    expression_to_array(pathway.theorem.body).map(G.addInteraction);
    
    pathway.steps.map(function (step) {
        var head = expression_to_array(step.head);
        var body = expression_to_array(step.body);

        var head_nodes = head.map(G.addInteraction);

        body
        .map(function (item) {
            var parent = G.getLeavesAsArray().find(function (leaf) {
                return equal(item, leaf.getValue()); 
            });
            head_nodes.map(function (node) { G.addEdge(parent, node); });
        });
    });




    
    // Computes level
    function calculate_level(node) {
if (node.getAttribute('level')) {
    return node.getAttribute('level');
}
        return node.isRoot()
             ? 0
             : Math.max.apply(null, node.getParentsAsArray().map(calculate_level)) + 1;
    }
    G.getNodesAsArray().map(function (node) {
        return node.setAttribute('level', calculate_level(node));
    });
    
    








    // Merges duplicates
    Q = G.getRootsAsArray();
    while (Q.length != 0) {
        var node = Q.shift();

        var duplicates = G.searchNodes(function (N) {
            return node !== N
                && node.getAttribute('level') === N.getAttribute('level')
                && equal(node.getValue(), N.getValue());
        });

        node.setAttribute('quantity', 1 + duplicates.length);

        Q = Q.filter(function (node) { return duplicates.indexOf(node) === -1; });
        duplicates.map(node.merge);

        node.getChildrenAsArray().map(function (child) { if (child.getAttribute('level') === node.getAttribute('level') + 1 && Q.indexOf(child) === -1) { Q.push(child); } });
    }




    // Pruning residuals
    function is_final_product(value) {
        return equal(pathway.theorem.head, value);

    }

    function is_residual(node) {
        return node.isLeaf() && !is_final_product(node.getValue());
    }

    function n2s(node) { return expression_to_string(node.getValue()); }
    function nn2s(nodes) { return nodes.map(n2s); }


    var Q = G.getRootsAsArray();
    while (Q.length !== 0) {
        var node = Q.shift();

        var residual_children = node.getChildrenAsArray().filter(is_residual);
        var non_residual_child = node.getChildrenAsArray().find(function (node) { return !is_residual(node); });
        node.getChildrenAsArray().map(function (node) {Q.push(node);});

        if (residual_children.length == 0) {
            continue;
        }

        if (!non_residual_child) {
            return G;
        }

        var clause = {
            _type: 'conjunction',
            components: residual_children.map(function (node) { 
                var residuals = [];
                for (var i = 0; i < node.getAttribute('quantity'); ++i) {
                    residuals.push(node.getValue());
                }
                return residuals;
            })
            .reduce(function (carry, item) {
                return carry.concat(item);
            }, []),
            quantity: node.getAttribute('quantity')
        }

        residual_children.map(function (node) { G.removeNode(node); });
        var residual_node = G.addInteraction(clause).setAttribute('type', 'residual').setAttribute('level', non_residual_child.getAttribute('level'));
        G.addEdge(residual_node, non_residual_child).setAttribute('type', 'residual');
    }


    return G;
}
