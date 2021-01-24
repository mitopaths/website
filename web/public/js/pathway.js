function position_to_code(position) {
    var color = 0;

    if (position & 0x1) color += 1;
    if (position & 0x2) color += 10;
    if (position & 0x4) color += 100;
    if (position & 0x8) color += 1000;
    if (position & 0x10) color += 10000;

    return color.toString().padStart(5, '0');
}






function graph_to_vis(G, max_level) {
    var max_level = (typeof max_level !== 'undefined') ? max_level : -1;

    var node_to_vis = function (N) {
        var shape = 'dot';
        if (N.getAttribute('type') === 'residual') {
            shape = 'square';
        }
        else if (N.getAttribute('type') === 'interaction') {
            shape = 'star';
        }

        var quantity = N.getAttribute('quantity');
        var title = (quantity > 1 ? quantity + "×" : "") + N.getAttribute('label');

        var label = title;
        if (label.length > 8) {
            label = label.substr(0, 8) + "...";
        }

        if (!N.getAttribute('position')) {
            var position = N
            .getParentsAsArray()
            .map(function (parent) { return parent.getAttribute('position'); })
            .reduce(function (a, b) { return a | b; }, 0);
            N.setAttribute('position', position);
        }
        var color = position_to_code(N.getAttribute('position'));

        return {
            id: N.getId(),
            shape: 'image',
            label: label,
            title: title,
            level: N.getAttribute('level'),
            image: '/mitopaths/public/icons/' + shape + '/' + color + '.svg'
        };
    }

    var edge_to_vis = function (E) {
        var is_residual = (Boolean(E.getAttribute('type')) && E.getAttribute('type') === 'residual');
        var quantity = E.getQuantity();

        return {
            from: E.getSource().getId(),
            to: E.getDestination().getId(),
            arrows: is_residual ? 'none' : 'to',
            dashes: is_residual,
            color: {
                color: '#999999',
                highlight: '#000000',
                hover:'#333333'
            },
            label: quantity > 1 ? (quantity + "×") : ""
        };
    }

    var node_below_max_level = function (node) {
        return max_level < 0 || node.getAttribute('level') <= max_level;
    }

    var edge_below_max_level = function (edge) {
        return max_level < 0
            || (edge.getSource().getAttribute('level') <= max_level && edge.getDestination().getAttribute('level') <= max_level);
    }

    
    return {
        nodes: new vis.DataSet(G.getNodesAsArray().filter(node_below_max_level).map(node_to_vis)),
        edges: new vis.DataSet(G.getEdgesAsArray().filter(edge_below_max_level).map(edge_to_vis))
    };
}


// Creates vis graph
function draw_graph(G, level, container) {
    var vis_graph = new vis.Network(
        container,
        graph_to_vis(G, level),
        {
            height: '100%',
            width: '100%',
            nodes: {
                shadow: true
            },
            edges: {
                smooth: {
                    type: "cubicBezier",
                    forceDirection: "none"
                },
                shadow: false
            },
            layout: {
                hierarchical: {
                    direction: 'DU',
                    sortMethod: 'directed',
                    parentCentralization: false,
                    levelSeparation: 100,
                    nodeSpacing: 50
                },
            },
            interaction: {
                dragNodes: true,
                hover: true
            },
            physics: {
                enabled: true
            },
        }
    );
}



// Draws theorem in dynamic view
function draw_dynamic_view_theorem(step, container) {
    container.html(theorem_to_url(step));
}



// Creates vis graph for dynamic mitolocation
function draw_dynamic_mitolocation(G, step, container, container_na) {

    G.getNodesAsArray().map(function (node) {
        var level = node.getAttribute('level') || 0;
        var children = node.getChildrenAsArray();

        var max_step = Math.max.apply(null, children.map(function (child) {
            return child.getAttribute('level');
        })) - 1;
        node.setAttribute('max_step', Math.max(max_step, level));

        node.setAttribute('mitolocation_level', function (position) {
            switch (position) {
                case 1: return 1;
                case 3: return 2;
                case 2: return 3;
                case 6: return 4;
                case 4: return 5;
                case 12: return 6;
                case 8: return 7;
                case 24: return 8;
                case 16: return 9;
                default: return 0;
            }
        } (node.getAttribute('position')));
    });

    var nodes = G.getNodesAsArray()
    .filter(function (node) {
        return step >= node.getAttribute('level') && step <= node.getAttribute('max_step');
    });



    var node_to_vis = function (N) {
        var shape = 'dot';
        if (N.getAttribute('type') === 'residual') {
            shape = 'square';
        }
        else if (N.getAttribute('type') === 'interaction') {
            shape = 'star';
        }

        var quantity = N.getAttribute('quantity');
        var title = (quantity > 1 ? quantity + "×" : "") + N.getAttribute('label');

        var label = title;
        if (label.length > 8) {
            label = label.substr(0, 8) + "...";
        }

        if (!N.getAttribute('position')) {
            var position = N
            .getParentsAsArray()
            .map(function (parent) { return parent.getAttribute('position'); })
            .reduce(function (a, b) { return a | b; }, 0);
            N.setAttribute('position', position);
        }
        var color = position_to_code(N.getAttribute('position'));

        return {
            id: N.getId(),
            shape: 'image',
            label: label,
            title: title,
            level: N.getAttribute('mitolocation_level'),
            image: '/mitopaths/public/icons/' + shape + '/' + color + '.svg'
        };
    }


    var vis_graph = new vis.Network(
        container,
        {
            nodes: new vis.DataSet(nodes.map(node_to_vis)),
        },
        {
            height: '100%',
            width: '100%',
            nodes: {
                shadow: true
            },
            layout: {
                hierarchical: {
                    direction: 'DU',
                    sortMethod: 'directed',
                    parentCentralization: false,
                    levelSeparation: 100,
                    nodeSpacing: 0,
                    treeSpacing: 75
                },
            },
            interaction: { 
                dragNodes: true,
                hover: true
            },
            physics: {
                enabled: false
            }
        }
    );
}





$(function () {
    $('.pathway-page').each(function () {
        var pathway = JSON.parse($(this).find('.pathway-json').html());
                
        // Writes main theorem
        var theorem_container = $(this).find('.pathway-theorem');
        theorem_container.html(theorem_to_url(pathway.theorem));
        
        // Writes demonstrative and biological steps
        var steps_container = $(this).find('.pathway-steps');
        $('<p class="small">Click on the step number to see it in the dynamic view</p>').appendTo(steps_container);
        var container = $('<ol class="biological-step-container">');
        for (var i = 0; i < pathway['steps'].length; ++i) {
            var step = pathway['steps'][i];
            $('<li class="biological-step" data-step-id="' + i + '" title="Show setp ' + i +' in dynamic view">').html(theorem_to_url(step)).appendTo(container);
        }
        container.appendTo(steps_container);
        

        // Renders dynamic view
        var dynamic_container = $(this).find('.pathway-dynamic-view');
        var dynamic_step_container = $(this).find('.pathway-dynamic-view-step');
        var dynamic_back = $(this).find('.pathway-dynamic-view-back');
        var dynamic_next = $(this).find('.pathway-dynamic-view-next');
        var dynamic_start = $(this).find('.pathway-dynamic-view-start');
        var dynamic_stop = $(this).find('.pathway-dynamic-view-stop');
        var dag = pathway_to_dag(pathway);
        var max_level = dag.getNodesAsArray().map(function (node) {
            return node.getAttribute('level');
        }).reduce(function (carry, item) {
            return Math.max(carry, item);
        }, 0);
        var level = max_level;
        
        draw_graph(dag, max_level, dynamic_container[0]);
        draw_dynamic_view_theorem(pathway['steps'][pathway['steps'].length - 1], dynamic_step_container);
        
        // Binds back- and next-step buttons
        dynamic_next.click(function () {
            level = (level < max_level) ? level + 1 : level;
            draw_graph(dag, level, dynamic_container[0]);
            draw_dynamic_view_theorem(pathway['steps'][level - 1], dynamic_step_container);
        });
        dynamic_back.click(function () {
            level = (level > 0) ? level - 1 : level;
            draw_graph(dag, level, dynamic_container[0]);
            if (level > 0) {
                draw_dynamic_view_theorem(pathway['steps'][level - 1], dynamic_step_container);
            }
            else {
                dynamic_step_container.html('');
            }
        });

        // Binds numbers in demonstrative and biological steps to dynamic view
        $('.biological-step').click(function() {
            var step = parseInt($(this).attr('data-step-id'));
            draw_graph(dag, step + 1, dynamic_container[0]);
            draw_dynamic_view_theorem(pathway['steps'][step], dynamic_step_container);
        });

        // Animation
        var timestep = 1500;
        var timer = null;
        var animate = function () {
            if (level === max_level) {
                level = -1;
            }

            dynamic_next.click();
            timer = setTimeout(animate, timestep);
        }

        // Binds animation controls
        dynamic_start.click(function () {
            animate();
        });
        dynamic_stop.click(function () {
            timer = clearTimeout(timer);
        });
        
        
        // Draws mito-location
        dag.getNodesAsArray().filter(function (node) {
            return !node.getAttribute('level');
        })
        .map(function (node) {
            var position = node.getAttribute('position');
            var item = $('<li>').addClass('list-inline-item').append(
                $('<a>')
                .attr('href', '/mitopaths/molecule/' + node.getValue().name)
                .html(node.getValue().name)
            );
            
            if (!position) {
                $('.mitolocation-na ul.list-inline').append(item.clone());
            }
            if (position & 0x1) {
                $('.mitolocation-m ul.list-inline').append(item.clone());
            }
            if (position & 0x2) {
                $('.mitolocation-im ul.list-inline').append(item.clone());
            }
            if (position & 0x4) {
                $('.mitolocation-ims ul.list-inline').append(item.clone());
            }
            if (position & 0x8) {
                $('.mitolocation-om ul.list-inline').append(item.clone());
            }
            if (position & 0x10) {
                $('.mitolocation-pms ul.list-inline').append(item.clone());
            }
        });


        // Draws dynamic mito-location
        var dynamic_location_container_na = $(this).find('.dynamic-mitolocation-na');
        var dynamic_location_container = $(this).find('.dynamic-mitolocation');
        var mitolocation_back = $(this).find('.pathway-dynamic-mitolocation-back');
        var mitolocation_next = $(this).find('.pathway-dynamic-mitolocation-next');
        var mitolocation_start = $(this).find('.pathway-dynamic-mitolocation-start');
        var mitolocation_stop = $(this).find('.pathway-dynamic-mitolocation-stop');
        var step = 0;
        var max_step = max_level;

        draw_dynamic_mitolocation(dag, step, dynamic_location_container[0], dynamic_location_container_na[0]);

        // Binds back- and next-step buttons
        mitolocation_next.click(function () {
            step = (step < max_step) ? step + 1 : step;
            draw_dynamic_mitolocation(dag, step, dynamic_location_container[0], dynamic_location_container_na[0]);
        });
        mitolocation_back.click(function () {
            step = (step > 0) ? step - 1 : step;
            draw_dynamic_mitolocation(dag, step, dynamic_location_container[0], dynamic_location_container_na[0]);
        });

        // Animation
        var mitolocation_timestep = 1500;
        var mitolocation_timer = null;
        var mitolocation_animate = function () {
            if (step === max_step) {
                step = -1;
            }

            mitolocation_next.click();
            mitolocation_timer = setTimeout(mitolocation_animate, mitolocation_timestep);
        }

        // Binds animation controls
        mitolocation_start.click(function () {
            mitolocation_animate();
        });
        mitolocation_stop.click(function () {
            mitolocation_timer = clearTimeout(mitolocation_timer);
        });
    });
});
