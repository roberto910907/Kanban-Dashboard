export default {
  getColumnList(boardUuid) {
    const query = gql`
      query getColumns {
        columns(board_id: "${boardUuid}") {
          data {
            id
            uuid
            title
            position
          }
        }
      }
    `;

    return useQuery(query);
  },
};
