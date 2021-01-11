-- List constants smaller than 1 ordered by their values
SELECT 
    c.cid,
    q.name,
    v.symbol,
    c.value,
    c.exponent,
    q.unit,
    c.creator
FROM
    Constants c
        INNER JOIN Variables v ON 
            c.cid = v.vid AND
            c.exponent<0
        INNER JOIN Quantities q ON 
            c.cid = q.qid AND
            c.exponent<0
ORDER BY 
    c.exponent;
  
 -- Number of differential equations of order 2 or more in every field
SELECT
    e.field,
    COUNT(*) AS equationsCount
FROM
    Equations e
        INNER JOIN Differential_equations de ON e.eqid = de.deid
WHERE
    de.eqOrder > 1
GROUP BY 
    e.field;
  
  --list all varaibles and constants having a specific unit
SELECT
    q.name,
    q.unit,
    v.symbol,
    c.value,
    c.exponent
FROM
    Quantities q
        LEFT JOIN Variables v ON q.qid = v.vid AND 
            q.unit = 'm^2 kg/s'
        LEFT JOIN Constants c ON q.qid = c.cid AND 
            q.unit = 'm^2 kg/s'
WHERE
    q.unit = 'm^2 kg/s';

--list all equations in a given field
SELECT 
    e.name,
    e.field,
    e.latexCode,
    de.eqOrder,
    pe.eqDegree
FROM
    Equations e
        LEFT JOIN Differential_equations de ON e.eqid = de.deid
        LEFT JOIN Polynomial_equations pe ON e.eqid = pe.peid
WHERE
    e.field = 'Kinematics'
ORDER BY eqDegree, eqOrder;

--Get info on a physicist, by returning a tuple containing its attributes
-- as well as the number of equations he/she created (in our db)-- 
SELECT
    name,
    nationality,
    birthYear,
    deathYear,
    (SELECT COUNT(*) FROM Constants WHERE creator = 'Max Plank') AS calculatedConstants,
    (SELECT COUNT(*) FROM Equations WHERE creator = 'Max Plank') AS createdEquations
FROM
    Physicists
WHERE
    name = 'Max Plank';

--List equations that contain a given variable or constant, group them by field
SELECT
    e.name,
    e.latexCode,
    de.eqOrder,
    pe.eqDegree
FROM
    Variables v,
    Part_of r,
    Quantities q,
    Equations e
        LEFT JOIN Differential_equations de ON e.eqid = de.deid
        LEFT JOIN Polynomial_equations pe ON e.eqid = pe.peid
WHERE
    e.eqid = r.eqid AND
    v.vid = r.vid AND
    v.vid = q.qid AND
    q.name = 'Velocity';

--search for variable or constant by name
SELECT
    q.name,
    q.unit,
    v.symbol,
    c.value,
    c.exponent
FROM
    Quantities q
        INNER JOIN Variables v ON q.qid = v.vid
        LEFT JOIN Constants c ON q.qid = c.cid
WHERE
    q.name = 'Velocity';

--search for variable or constant by symbol
SELECT
    q.name,
    q.unit,
    v.symbol,
    c.value,
    c.exponent
FROM
    Quantities q,
    Variables v
        LEFT JOIN Constants c ON v.vid = c.cid
WHERE
    q.qid = v.vid AND
    v.symbol = 'h';

--get information about an equation by name
SELECT
    e.name,
    e.latexCode,
    e.field,
    e.creator,
    de.eqOrder,
    pe.eqDegree
FROM
    Equations e
        LEFT JOIN Differential_equations de ON e.eqid = de.deid
        LEFT JOIN Polynomial_equations pe ON e.eqid = pe.peid
WHERE
    e.name = 'Wave Equation';

--get information on all fields
SELECT
    f.name,
    (SELECT COUNT(*) FROM Equations e WHERE e.field = f.name) AS equationsCount
FROM
    Fields f
GROUP BY f.name
ORDER BY equationsCount;