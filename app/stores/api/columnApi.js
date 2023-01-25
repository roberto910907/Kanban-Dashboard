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
            cards {
                id
                uuid
                title
                position
                description
            }
          }
        }
      }
    `;

    return useQuery(query);
  },

  createColumn(newColumn) {
    const query = gql`
        mutation createColumn {
            createColumn(title: "${newColumn.title}", board_id: "${newColumn.board_id}") {
                id
                uuid
                title
                position
                cards {
                    id
                }
            }
        }
    `;

    return useMutation(query);
  },

  deleteColumn(columnId) {
    const query = gql`
        mutation deleteColumn {
            deleteColumn(id: "${columnId}") {
                uuid
            }
        }
    `;

    return useMutation(query);
  },
};
