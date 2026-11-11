<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$country = $_GET['country'] ?? '';
$query = 'SELECT name, continent, independence_year, head_of_state
          FROM countries
          WHERE name LIKE :country';

$stmt = $conn->prepare($query);
$stmt->execute(['country' => '%' . $country . '%']);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="table-wrapper">
  <table class="country-table">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Continent</th>
        <th scope="col">Independence Year</th>
        <th scope="col">Head of State</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($results): ?>
        <?php foreach ($results as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row['continent'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($row['independence_year'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row['head_of_state'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td class="no-results" colspan="4">No countries found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
