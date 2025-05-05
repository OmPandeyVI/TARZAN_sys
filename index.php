<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hot Wheels Style Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .progress-track {
      position: relative;
      height: 120px;
      margin-top: 60px;
      background: linear-gradient(to right, #dee2e6, #ced4da);
      border-radius: 50px;
      box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
    }
    .checkpoint {
      width: 20px;
      height: 20px;
      background-color: #6c757d;
      border-radius: 50%;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 1;
    }
    .checkpoint.active {
      background-color: #198754;
      box-shadow: 0 0 15px #198754;
    }
    .car {
      width: 80px;
      height: 40px;
      background: url('download.png') no-repeat center center / contain;
      position: absolute;
      top: 40px;
      z-index: 2;
      cursor: grab;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="text-center mt-5">🚗 Project: Build Dashboard System</h2>

  <div class="progress-track mx-auto" id="track">
    <div id="car" class="car"></div>
  </div>
</div>

<!-- CDN Scripts -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Draggable.min.js"></script>

<script>
  const checkpoints = ['Planning', 'Design', 'Development', 'Testing', 'Deployment'];
  const track = document.getElementById('track');
  const car = document.getElementById('car');
  const carWidth = 80;
  const total = checkpoints.length;
  const spacing = track.clientWidth / (total - 1);
  const activeIndex = 2;

  // Place checkpoints
  checkpoints.forEach((label, i) => {
    const dot = document.createElement('div');
    dot.className = 'checkpoint' + (i <= activeIndex ? ' active' : '');
    dot.style.left = `calc(${(i / (total - 1)) * 100}% - 10px)`;
    track.appendChild(dot);
  });

  // Position car initially
  gsap.set(car, {
    x: spacing * activeIndex - carWidth / 2
  });

  // Make car draggable
  Draggable.create(car, {
    type: "x",
    bounds: {
      minX: 0 - carWidth / 2,
      maxX: (total - 1) * spacing - carWidth / 2
    },
    inertia: true,
    onDrag() {
      // Optional: glow on nearby checkpoints
    },
    onRelease() {
      // Snap to nearest checkpoint
      const nearest = Math.round(this.x / spacing);
      const finalX = nearest * spacing - carWidth / 2;

      gsap.to(car, {
        x: finalX,
        duration: 0.5,
        ease: "elastic.out(1, 0.6)",
        onStart: () => {
          gsap.to(car, { scale: 1.1, duration: 0.2 });
        },
        onComplete: () => {
          gsap.to(car, { scale: 1, duration: 0.2 });
        }
      });

      // Glow effect
      document.querySelectorAll('.checkpoint').forEach((cp, i) => {
        cp.classList.toggle('active', i <= nearest);
      });
    }
  });
</script>

</body>
</html>
