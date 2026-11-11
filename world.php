<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? '';

$query = $lookup === 'cities'
    ? 'SELECT cities.name, cities.district, cities.population
       FROM cities
       INNER JOIN countries ON cities.country_code = countries.code
       WHERE countries.name LIKE :country'
    : 'SELECT name, continent, independence_year, head_of_state
       FROM countries
       WHERE name LIKE :country';

$stmt = $conn->prepare($query);
$stmt->execute(['country' => '%' . $country . '%']);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="table-wrapper">
  <table class="results-table">
    <thead>
      <tr>
        <?php if ($lookup === 'cities'): ?>
          <th scope="col">Name</th>
          <th scope="col">District</th>
          <th scope="col">Population</th>
        <?php else: ?>
          <th scope="col">Name</th>
          <th scope="col">Continent</th>
          <th scope="col">Independence Year</th>
          <th scope="col">Head of State</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php if ($results): ?>
        <?php foreach ($results as $row): ?>
          <tr>
            <?php if ($lookup === 'cities'): ?>
              <td><?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['district'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars((string) ($row['population'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <?php else: ?>
              <td><?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['continent'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars((string) ($row['independence_year'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['head_of_state'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td class="no-results" colspan="<?= $lookup === 'cities' ? '3' : '4' ?>">
            <?= $lookup === 'cities' ? 'No cities found.' : 'No countries found.' ?>
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
