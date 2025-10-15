<?php

function getStudentsByFilter($pdo, $nomf, $code, $sex) {
    if ($code == "all" || empty($code)) {
        $sql = "SELECT * FROM Etudiant WHERE nom LIKE ? AND sex LIKE ?";
        $params = ["%$nomf%", $sex === "all" ? "%" : $sex];
    } else {
        $sql = "SELECT * FROM Etudiant WHERE (nom LIKE ? OR prenom LIKE ?) AND code = ? AND sex LIKE ?";
        $params = ["%$nomf%", "%$nomf%", $code, $sex === "all" ? "%" : $sex];
    }
    $query = $pdo->prepare($sql);
    $query->execute($params);
    return $query->fetchAll();
}

function countStudents($pdo, $nomf, $code, $sex) {
    if ($code == "all" || empty($code)) {
        $sql = "SELECT COUNT(*) AS countF FROM Etudiant WHERE nom LIKE ? AND sex LIKE ?";
        $params = ["%$nomf%", $sex === "all" ? "%" : $sex];
    } else {
        $sql = "SELECT COUNT(*) AS countF FROM Etudiant WHERE (nom LIKE ? OR prenom LIKE ?) AND code = ? AND sex LIKE ?";
        $params = ["%$nomf%", "%$nomf%", $code, $sex === "all" ? "%" : $sex];
    }
    $query = $pdo->prepare($sql);
    $query->execute($params);
    return $query->fetch()['countF'];
}
