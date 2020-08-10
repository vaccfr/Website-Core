var FIR = {
  type: 'FeatureCollection',
  features: [
    {
      type: 'Feature',
      properties: {
        name: 'LFRR',
        popupContent:
          '<strong>Brest Control</strong><br> <center>199.998</center>',
        show_on_map: true,
        style: {
          fill: "#7987ff",
          weight: 1,
          opacity: 0.1,
          fillOpacity: 0.2,
        },
      },
      geometry: {
        type: 'Polygon',
        coordinates: [
          [
            [-0.25, 50],
            [-0.25, 46.5],
            [-1.6333333333333, 46.5],
            [-1.7833333333333, 43.583333333333],
            [-4, 43.583333333333],
            [-4, 44.333333333333],
            [-8, 45],
            [-8, 48.833333333333],
            [-2, 50],
            [-0.25, 50],
          ],
        ],
      },
    },
  ],
};
