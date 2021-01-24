function Graph(is_equivalent) {
    var nodes = [];
    var edges = [];
    var is_equivalent = (typeof is_equivalent !== 'undefined')
        ? is_equivalent
        : function (value_A, value_B) { return value_A === value_B; };
    var next_node_id = 0;
    var graph = this;


    function Node(value) {
        var id = next_node_id++;
        var value = value;
        var attributes = {};
        var self = this;


        this.isEqual = function (that) {
            return id === that.getId();
        }


        this.isRoot = function () {
            return this.getParentsAsArray().length === 0;
        }


        this.isLeaf = function () {
            return this.getChildrenAsArray().length === 0;
        }


        this.getId = function () {
            return id;
        }


        this.getValue = function () {
            return value;
        }


        this.getAttribute = function (name) {
            return attributes[name] ? attributes[name] : null;
        }


        this.getParentsAsArray = function () {
            return edges
                   .filter(function (edge) { return self === edge.getDestination(); })
                   .map(function (edge) { return edge.getSource(); });
        }


        this.getChildrenAsArray = function () {
            return edges
                   .filter(function (edge) { return self === edge.getSource(); })
                   .map(function (edge) { return edge.getDestination(); });
        }


        this.setAttribute = function (name, value) {
            attributes[name] = value;
            return self;
        }

        this.merge = function (that) {
            edges
            .filter(function (edge) { return that === edge.getDestination(); })
            .map(function (edge) { return edge.getSource(); })
            .map(function (node) { graph.removeEdge(node, that); graph.addEdge(node, self); });

            edges
            .filter(function (edge) { return that === edge.getSource(); })
            .map(function (edge) { return edge.getDestination(); })
            .map(function (node) { graph.removeEdge(that, node); graph.addEdge(self, node); });

            graph.removeNode(that);

            return self;
        }

        return this;
    }


    function Edge(source, destination) {
        var source = source;
        var destination = destination;
        var quantity = 1;
        var attributes = {};
        var self = this;


        this.getSource = function () {
            return source;
        }


        this.getDestination = function () {
            return destination;
        }


        this.getQuantity = function () {
            return quantity;
        }


        this.getAttribute = function (name) {
            return attributes[name] ? attributes[name] : null;
        }


        this.getAttributesAsObject = function () {
            return attributes;
        }


        this.setQuantity = function (new_quantity) {
            quantity = new_quantity;
            return self;
        }


        this.setAttribute = function (name, value) {
            attributes[name] = value;
            return self;
        }

        return this;
    }



    this.getNodesAsArray = function () {
        return nodes;
    }


    this.searchNodes = function (condition) {
        return this.getNodesAsArray().filter(condition);
    }


    this.getRootsAsArray = function () {
        return this.searchNodes(function (node) { return node.isRoot(); });
    }


    this.getLeavesAsArray = function () {
        return this.searchNodes(function (node) { return node.isLeaf(); });
    }


    this.getInducedSubgraph = function (nodes) {
        var G = new Graph();
        var is_in_nodes = function (node) { return nodes.indexOf(node) !== -1; };

        nodes.map(G.pushNode);

        edges
        .filter(function (edge) {return is_in_nodes(edge.getSource()) && is_in_nodes(edge.getDestination()); })
        .map(function (edge) { G.addEdge(edge.getSource(), edge.getDestination()); });

        return G;
    }


    this.getEdgesAsArray = function () {
        return edges;
    }


    this.addNode = function (value) {
        var node = new Node(value);
        nodes.push(node);
        return node;
    }


    this.pushNode = function (node) {
        nodes.push(node);
        return self;
    }


    this.removeNode = function (node) {
        nodes = nodes.filter(function (item) { return node !== item; });
        edges = edges.filter(function (edge) { return node !== edge.getSource() && node !== edge.getDestination(); });
        return self;
    }


    this.addEdge = function (source, destination) {
        var edge = edges.find(function (edge) { return source === edge.getSource() && destination === edge.getDestination(); });
        if (typeof edge !== 'undefined') {
            return edge.setQuantity(edge.getQuantity() + 1);
        }

        var edge = new Edge(source, destination);
        edges.push(edge);
        return edge;
    }


    this.removeEdge = function (source, destination) {
        edges = edges.filter(function (edge) { return source !== edge.getSource() || destination !== edge.getDestination(); });
        return self;
    }

    return this;
}