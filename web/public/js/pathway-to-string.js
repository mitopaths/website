function position_to_string(position) {
    if (position === 0) {
        return "N/A";
    }
    
    if (position = 0x1F) {
        return "Any";
    }
    
    positions = [];
    if (position & 0x10) {
        positions.push("PMS");
    }
    if (positions & 0x8) {
        positions.push("OM");
    }
    if (position & 0x4) {
        positions.push("IMS");
    }
    if (positions & 0x2) {
        positions.push("IM");
    }
    if (positions & 0x1) {
        positions.push("M");
    }
    
    return positions.join(", ");
}


function molecule_to_string(molecule) {
    var name = molecule.name;
    var label = molecule.label || name;
    
    return label;
}


function protein_to_string(protein) {
    var name = protein.name;
    var label = protein.label || name;
    
    return label;
}


function mutated_protein_to_string(mutated_protein) {
    var name = mutated_protein.name;
    var label = mutated_protein.label || name;
    
    return label;
}


function interaction_to_string(interaction) {
    return interaction.label
    || ("(" + interaction.components.map(expression_to_string).join(" * ") + ")");
}


function conjunction_to_string(conjunction) {
    return conjunction.components.map(expression_to_string).join(" & ");
}


function expression_to_string(expression) {
    switch (expression['_type']) {
        case 'molecule': return molecule_to_string(expression);
        case 'protein': return protein_to_string(expression);
        case 'mutated_protein': return mutated_protein_to_string(expression);
        case 'interaction': return interaction_to_string(expression);
        case 'conjunction': return conjunction_to_string(expression);
        default: return "";
    };
}


function theorem_to_string(theorem) {
    return expression_to_string(theorem.body) + " &rArr; " + expression_to_string(theorem.head);
}



function molecule_to_url(molecule) {
    var name = molecule.name;
    var label = molecule.label || name;
    
    return '<a href="/mitopaths/molecule/' + name + '" title="See ' + name + '">' + label + '</a>';
}


function protein_to_url(protein) {
    var name = protein.name;
    var label = protein.label || name;
    
    return '<a href="/mitopaths/molecule/' + name + '" title="See ' + name + '">' + label + '</a>';
}


function mutated_protein_to_url(mutated_protein) {
    var name = mutated_protein.name;
    var label = mutated_protein.label || name;
    
    return '<a href="/mitopaths/molecule/' + name + '" title="See ' + name + '">' + label + '</a>';
}


function interaction_to_url(interaction) {
    return interaction.label
    || ("(" + interaction.components.map(expression_to_url).join(" * ") + ")");
}


function conjunction_to_url(conjunction) {
    return conjunction.components.map(expression_to_url).join(" & ");
}


function expression_to_url(expression) {
    switch (expression['_type']) {
        case 'molecule': return molecule_to_url(expression);
        case 'protein': return protein_to_url(expression);
        case 'mutated_protein': return mutated_protein_to_url(expression);
        case 'interaction': return interaction_to_url(expression);
        case 'conjunction': return conjunction_to_url(expression);
        default: return "";
    };
}


function theorem_to_url(theorem) {
    return expression_to_url(theorem.body) + " &rArr; " + expression_to_url(theorem.head);
}
