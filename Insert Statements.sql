INSERT INTO Authorization(username, password)
    VALUES
    ('admin', 'MxNs1UQ');

INSERT INTO Physicists (name, nationality, birthYear, deathYear) 
    VALUES
    ('Albert Einstein', 'German', 1879, 1955),
    ('Max Plank', 'German', 1858, 1947),
    ('Amedeo Avogadro', 'Italian', 1776, 1856),
    ('Niels Bohr', 'Danish', 1885, 1962),
    ('Robert Millikan', 'American', 1868, 1953),
    ('Leonhard Euler', 'Swiss', 1707, 1783),
    ('Issac Newton', 'English',1643, 1727);

INSERT INTO Fields (name) 
    VALUES
    ('Kinematics'),
    ('Waves'),
    ('Electrodynamics'),
    ('Quantum Physics');

INSERT INTO Quantities (qid, name, unit) 
    VALUES
    (1, 'Avogadros Number', NULL),
    (2, 'Planks Constant', 'm^2 kg/s'),
    (3, 'Velocity', 'm/s'),
    (4, 'Acceleration', 'm/s^2'),
    (5, 'Time', 's'),
    (6, 'Distance', 'm'),
    (7, 'Charge of electorn', 'e'),
    (8, 'Angular velocity', 'rad/s'),
    (9, 'Energy', 'Joules'),
    (10, 'Frequency','s^(-1)'),
    (11, 'Force', 'N'),
    (12, 'Momemntum', 'kg m/s'),
    (13, 'Mass', 'kg'),
    (14, 'Gravitational Constant', 'N m^2 / kg^2');

INSERT INTO Variables (vid, symbol) 
    VALUES
    (1, 'NA'),
    (2, 'h'),
    (3, 'v'),
    (4, 'a'),
    (5, 't'),
    (6, 'x'),
    (7, 'e'),
    (8, '\omega'),
    (9, 'E'),
    (10, 'f'),
    (11, 'F'),
    (12, 'P'),
    (13, 'm'),
    (14, 'G');
    
INSERT INTO Constants (cid, value, exponent, creator) 
    VALUES
    (1, 6.02214, 23, 'Amedeo Avogadro'),
    (2, 6.62607, -34, 'Max Plank'),
    (7, -1.602, -19, 'Robert Millikan'),
    (14, 6.67, -11, 'Issac Newton');

INSERT INTO Equations (eqid, name, latexCode, field, creator) 
    VALUES
    (1, 'First Kinematic Equation', 'v = v0 + at', 'Kinematics', NULL),
    (2, 'Second Kinematic Equation', 'delta x = (v + v0)/2 * t', 'Kinematics', NULL),
    (3, 'Third Kinematic Equation', 'delta x = v0t + 0.5at^2', 'Kinematics', NULL),
    (4, 'Forth Kinematic Equation', 'v^2 = v0^2 + 2a * delta x', 'Kinematics', NULL),
    (5, 'Wave Equation', '\frac{d^y}{dx^2} = \frac{1}{v^2} \frac{d^2y}{dt^2}', 'Waves', 'Leonhard Euler'),
    (6, 'Simple Harmonic Motion', '\frac{d^2x}{dt^2} + \omega ^2 x = 0', 'Kinematics', NULL),
    (7, 'Plank Equation', 'E = hf', 'Quantum Physics', 'Max Plank'),
    (8, 'Second law of motion', 'F = \frac{dP}{dt}', 'Kinematics', 'Issac Newton'),
    (9, 'Law of Gravitation', 'G = G \frac{m_1 m_2}{r^2}','Kinematics', 'Issac Newton');

INSERT INTO Differential_equations (deid, eqOrder) 
    VALUES
    (5, 2),
    (6, 2);

INSERT INTO Polynomial_equations (peid, eqDegree) 
    VALUES
    (1, 1),
    (2, 1),
    (3, 2),
    (4, 2),
    (7, 1),
    (8, 1),
    (9, 2);

INSERT INTO Part_of (vid, eqid) 
    VALUES
    (3, 1),
    (4, 1),
    (5, 1),
    (3, 2),
    (5, 2),
    (6, 2),
    (4, 3),
    (5, 3),
    (6, 3),
    (3, 4),
    (4, 4),
    (6, 4),
    (3, 5),
    (8,6),
    (2,7),
    (9, 7),
    (10, 7),
    (5, 8),
    (11, 8),
    (12, 8),
    (13, 9),
    (14, 9),
    (11, 9);
